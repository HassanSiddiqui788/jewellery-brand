<?php

declare(strict_types=1);

use Core\Application;

require_once __DIR__ . '/autoload.php';

if (!function_exists('app_bootstrap')) {
    /**
     * Initialize or return the booted Application singleton cleanly.
     */
    function app_bootstrap(bool $registerErrorHandlers = true, ?string $envFile = null): Application
    {
        $existing = Application::getInstance();
        if ($existing instanceof Application) {
            return $existing;
        }

        $app = new Application(BASE_PATH);
        $app->boot($registerErrorHandlers, $envFile);
        Application::setInstance($app);

        return $app;
    }
}

return app_bootstrap(PHP_SAPI !== 'cli');

