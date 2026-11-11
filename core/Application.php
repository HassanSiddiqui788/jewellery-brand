<?php

declare(strict_types=1);

namespace Core;

use Core\Config\ConfigRepository;
use Core\Config\EnvLoader;
use Core\Database\Connection;
use Core\Database\Migrator;
use Core\Exceptions\ErrorHandler;
use Core\Http\Request;
use Core\Http\Response;
use Core\Logging\Logger;
use Core\Middleware\CsrfMiddleware;
use Core\Middleware\MiddlewareRegistry;
use Core\Middleware\SecurityMiddleware;
use Core\Middleware\SessionMiddleware;
use Core\Router\Router;
use Core\Session\SessionManager;

/**
 * Lightweight Application Kernel & Reflection Dependency Container.
 */
final class Application
{
    private static ?self $instance = null;

    /** @var array<string, object> */
    private array $singletons = [];

    /** @var array<string, bool> */
    private array $resolving = [];

    private bool $booted = false;

    public function __construct(private readonly string $basePath)
    {
    }

    public static function getInstance(): ?self
    {
        return self::$instance;
    }

    public static function setInstance(?self $app): void
    {
        self::$instance = $app;
    }

    public function boot(bool $registerErrorHandlers = true, ?string $envFile = null): self
    {
        if ($this->booted) {
            return $this;
        }

        $envPath = $envFile ?? $this->basePath . '/.env';
        if (is_file($envPath)) {
            EnvLoader::load($envPath);
        }

        $config = ConfigRepository::loadFromPath($this->basePath . '/config');
        $GLOBALS['__app_config'] = $config;

        $timezone = (string) $config->get('app.timezone', 'UTC');
        if ($timezone !== '') {
            @date_default_timezone_set($timezone);
        }

        $logPath = (string) $config->get('app.logging.path', $this->basePath . '/storage/logs/app.log');
        $logLevel = (string) $config->get('app.logging.level', 'debug');
        $logger = new Logger($logPath, $logLevel);
        $GLOBALS['__app_logger'] = $logger;

        $debug = (bool) $config->get('app.debug', false);
        $errorHandler = new ErrorHandler($logger, $debug);
        if ($registerErrorHandlers) {
            $errorHandler->register();
        }

        $session = new SessionManager((array) $config->get('session', []));
        $GLOBALS['__app_session'] = $session;

        $connection = Connection::fromConfig($config, $logger);
        $migrator = new Migrator($connection, $this->basePath . '/database/migrations');

        $middlewareRegistry = new MiddlewareRegistry(fn (string $class): object => $this->make($class));
        $middlewareRegistry->alias('security', SecurityMiddleware::class);
        $middlewareRegistry->alias('session', SessionMiddleware::class);
        $middlewareRegistry->alias('csrf', CsrfMiddleware::class);
        $middlewareRegistry->group('web', ['security', 'session', 'csrf']);
        $middlewareRegistry->group('api', ['security']);

        $router = new Router(
            $middlewareRegistry,
            function (mixed $handler, Request $request): mixed {
                return $this->invokeControllerOrCallable($handler, $request);
            }
        );

        $this->bindInstance(self::class, $this);
        $this->bindInstance(ConfigRepository::class, $config);
        $this->bindInstance(Logger::class, $logger);
        $this->bindInstance(ErrorHandler::class, $errorHandler);
        $this->bindInstance(SessionManager::class, $session);
        $this->bindInstance(Connection::class, $connection);
        $this->bindInstance(Migrator::class, $migrator);
        $this->bindInstance(MiddlewareRegistry::class, $middlewareRegistry);
        $this->bindInstance(Router::class, $router);

        $this->loadRoutes($router);
        $this->booted = true;

        return $this;
    }

    public function bindInstance(string $abstract, object $instance): void
    {
        $this->singletons[$abstract] = $instance;
    }

    public function make(string $class): object
    {
        if (isset($this->singletons[$class])) {
            return $this->singletons[$class];
        }

        if (isset($this->resolving[$class])) {
            throw new \RuntimeException(sprintf('Circular dependency detected while resolving "%s".', $class));
        }

        if (!class_exists($class)) {
            throw new \RuntimeException(sprintf('Class "%s" does not exist.', $class));
        }

        $this->resolving[$class] = true;

        try {
            $reflection = new \ReflectionClass($class);
            if (!$reflection->isInstantiable()) {
                throw new \RuntimeException(sprintf('Class "%s" is not instantiable.', $class));
            }

            $constructor = $reflection->getConstructor();
            if ($constructor === null || $constructor->getNumberOfParameters() === 0) {
                return new $class();
            }

            $dependencies = [];
            foreach ($constructor->getParameters() as $param) {
                $type = $param->getType();

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    $dependencies[] = $this->make($type->getName());
                    continue;
                }

                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                    continue;
                }

                if ($param->allowsNull()) {
                    $dependencies[] = null;
                    continue;
                }

                throw new \RuntimeException(sprintf(
                    'Unable to resolve parameter "$%s" of class "%s".',
                    $param->getName(),
                    $class
                ));
            }

            return $reflection->newInstanceArgs($dependencies);
        } finally {
            unset($this->resolving[$class]);
        }
    }

    public function handleHttp(Request $request): Response
    {
        /** @var Router $router */
        $router = $this->make(Router::class);
        /** @var ErrorHandler $errorHandler */
        $errorHandler = $this->make(ErrorHandler::class);

        try {
            return $router->dispatch($request);
        } catch (\Throwable $e) {
            return $errorHandler->renderThrowable($e, $request);
        }
    }

    public function basePath(): string
    {
        return $this->basePath;
    }

    public function config(): ConfigRepository
    {
        /** @var ConfigRepository $cfg */
        $cfg = $this->make(ConfigRepository::class);
        return $cfg;
    }

    public function logger(): Logger
    {
        /** @var Logger $logger */
        $logger = $this->make(Logger::class);
        return $logger;
    }

    public function session(): SessionManager
    {
        /** @var SessionManager $session */
        $session = $this->make(SessionManager::class);
        return $session;
    }

    public function db(): Connection
    {
        /** @var Connection $db */
        $db = $this->make(Connection::class);
        return $db;
    }

    public function migrator(): Migrator
    {
        /** @var Migrator $migrator */
        $migrator = $this->make(Migrator::class);
        return $migrator;
    }

    public function router(): Router
    {
        /** @var Router $router */
        $router = $this->make(Router::class);
        return $router;
    }

    public function middlewareRegistry(): MiddlewareRegistry
    {
        /** @var MiddlewareRegistry $registry */
        $registry = $this->make(MiddlewareRegistry::class);
        return $registry;
    }

    private function invokeControllerOrCallable(mixed $handler, Request $request): mixed
    {
        if (is_array($handler) && count($handler) === 2 && is_string($handler[0])) {
            $controller = $this->make($handler[0]);
            $method = $handler[1];
            return $controller->{$method}($request);
        }

        if (is_callable($handler)) {
            return $handler($request);
        }

        throw new \RuntimeException('Invalid route handler configuration.');
    }

    private function loadRoutes(Router $router): void
    {
        $webRoutes = $this->basePath . '/routes/web.php';
        if (is_file($webRoutes)) {
            $registrar = require $webRoutes;
            if (is_callable($registrar)) {
                $router->group(['middleware' => 'web'], static function (Router $r) use ($registrar): void {
                    $registrar($r);
                });
            }
        }

        $apiRoutes = $this->basePath . '/routes/api.php';
        if (is_file($apiRoutes)) {
            $registrar = require $apiRoutes;
            if (is_callable($registrar)) {
                $router->group(['prefix' => 'api/v1', 'middleware' => 'api'], static function (Router $r) use ($registrar): void {
                    $registrar($r);
                });
            }
        }
    }
}

