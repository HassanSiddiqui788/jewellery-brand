<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Contracts\MiddlewareInterface;
use Core\Exceptions\CsrfTokenMismatchException;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware\CsrfMiddleware;
use Core\Middleware\MiddlewarePipeline;
use Core\Middleware\MiddlewareRegistry;
use Core\Middleware\SecurityMiddleware;
use Core\Middleware\SessionMiddleware;
use Core\Router\Router;
use Core\Session\SessionManager;
use Tests\Assert;

final class RouterAndMiddlewareTest
{
    public function testRestMethodsRouteParamsAndNamedUrls(): void
    {
        $registry = new MiddlewareRegistry();
        $router = new Router($registry);

        $router->get('/items', fn () => Response::text('index'))->name('items.index');
        $router->post('/items', fn () => Response::text('created', 201));
        $router->put('/items/{id:\d+}', fn (Request $req) => Response::text('put:' . $req->routeParam('id')));
        $router->patch('/items/{id:\d+}', fn (Request $req) => Response::text('patch:' . $req->routeParam('id')));
        $router->delete('/items/{id:\d+}', fn (Request $req) => Response::text('delete:' . $req->routeParam('id')));

        Assert::same('/items', $router->url('items.index'));
        Assert::same('index', $router->dispatch(new Request('GET', '/items'))->getContent());
        Assert::same(201, $router->dispatch(new Request('POST', '/items'))->getStatusCode());
        Assert::same('put:42', $router->dispatch(new Request('POST', '/items/42', body: ['_method' => 'PUT']))->getContent());
        Assert::same('patch:42', $router->dispatch(new Request('PATCH', '/items/42'))->getContent());
        Assert::same('delete:42', $router->dispatch(new Request('DELETE', '/items/42'))->getContent());
    }

    public function test404And405Handling(): void
    {
        $router = new Router(new MiddlewareRegistry());
        $router->get('/only-get', fn () => Response::text('ok'));

        Assert::throws(NotFoundException::class, static function () use ($router): void {
            $router->dispatch(new Request('GET', '/non-existent-route'));
        });

        /** @var MethodNotAllowedException $e */
        $e = Assert::throws(MethodNotAllowedException::class, static function () use ($router): void {
            $router->dispatch(new Request('POST', '/only-get'));
        });

        Assert::same(405, $e->getStatusCode());
        Assert::contains('GET', $e->getHeaders()['Allow'] ?? '');
    }

    public function testMiddlewareExecutionOrderAndSecurityHeaders(): void
    {
        $trace = [];
        $mwA = new class ($trace) implements MiddlewareInterface {
            public function __construct(private array &$trace) {}
            public function handle(Request $request, callable $next): Response {
                $this->trace[] = 'A:before';
                $res = $next($request);
                $this->trace[] = 'A:after';
                return $res;
            }
        };
        $mwB = new class ($trace) implements MiddlewareInterface {
            public function __construct(private array &$trace) {}
            public function handle(Request $request, callable $next): Response {
                $this->trace[] = 'B:before';
                $res = $next($request);
                $this->trace[] = 'B:after';
                return $res;
            }
        };

        $pipeline = (new MiddlewarePipeline())->through([$mwA, $mwB, new SecurityMiddleware()]);
        $response = $pipeline->handle(new Request('GET', '/'), function () use (&$trace): Response {
            $trace[] = 'controller';
            return Response::html('<p>ok</p>');
        });

        Assert::same(['A:before', 'B:before', 'controller', 'B:after', 'A:after'], $trace);
        Assert::same('nosniff', $response->getHeader('X-Content-Type-Options'));
        Assert::same('SAMEORIGIN', $response->getHeader('X-Frame-Options'));
    }

    public function testCsrfMiddlewareProtectionOnWriteRequests(): void
    {
        $_SESSION = [];
        $session = new SessionManager(['lifetime' => 120, 'http_only' => true, 'same_site' => 'Lax']);
        $session->start();
        $token = $session->csrfToken();

        $registry = new MiddlewareRegistry();
        $registry->alias('session', static fn () => new SessionMiddleware($session));
        $registry->alias('csrf', static fn () => new CsrfMiddleware($session));
        $registry->group('web', ['session', 'csrf']);

        $router = new Router($registry);
        $router->group(['middleware' => 'web'], static function (Router $r): void {
            $r->get('/form', fn () => Response::text('ok'));
            $r->post('/submit', fn () => Response::text('accepted'));
        });

        Assert::same('ok', $router->dispatch(new Request('GET', '/form'))->getContent());

        Assert::throws(CsrfTokenMismatchException::class, static function () use ($router): void {
            $router->dispatch(new Request('POST', '/submit', body: ['_token' => 'wrong-token']));
        });

        $validBodyRes = $router->dispatch(new Request('POST', '/submit', body: ['_token' => $token]));
        Assert::same('accepted', $validBodyRes->getContent());

        $validHeaderRes = $router->dispatch(new Request('POST', '/submit', headers: ['X-CSRF-TOKEN' => $token]));
        Assert::same('accepted', $validHeaderRes->getContent());
    }
}

