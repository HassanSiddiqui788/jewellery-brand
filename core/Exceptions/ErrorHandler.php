<?php

declare(strict_types=1);

namespace Core\Exceptions;

use Core\Http\Request;
use Core\Http\Response;
use Core\Logging\Logger;

/**
 * Global exception and error handler that logs securely and never exposes sensitive internals.
 */
final class ErrorHandler
{
    public function __construct(
        private readonly Logger $logger,
        private readonly bool $debug = false
    ) {
    }

    public function register(): void
    {
        set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
            if (!(error_reporting() & $severity)) {
                return false;
            }

            // Log warnings/notices cleanly without aborting legacy procedural templates
            if (in_array($severity, [E_WARNING, E_NOTICE, E_USER_WARNING, E_USER_NOTICE, E_DEPRECATED, E_USER_DEPRECATED], true)) {
                $logMethod = in_array($severity, [E_WARNING, E_USER_WARNING], true) ? 'warning' : 'notice';
                $this->logger->{$logMethod}($message, ['file' => $file, 'line' => $line, 'severity' => $severity]);
                return true;
            }

            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function (\Throwable $exception): void {
            $request = PHP_SAPI !== 'cli' ? Request::capture() : null;
            $response = $this->renderThrowable($exception, $request);

            if (PHP_SAPI === 'cli') {
                fwrite(STDERR, sprintf("[%s] %s\n", $exception::class, $exception->getMessage()));
                exit(1);
            }

            $response->send();
        });

        register_shutdown_function(function (): void {
            $error = error_get_last();
            if ($error === null) {
                return;
            }

            $fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR];
            if (!in_array($error['type'], $fatalTypes, true)) {
                return;
            }

            $exception = new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
            $this->logger->critical('Fatal PHP shutdown error', ['exception' => $exception]);
        });
    }

    public function renderThrowable(\Throwable $exception, ?Request $request = null): Response
    {
        $statusCode = $exception instanceof HttpException ? $exception->getStatusCode() : 500;
        $headers = $exception instanceof HttpException ? $exception->getHeaders() : [];

        if ($statusCode >= 500) {
            $this->logger->exception($exception, [
                'uri' => $request?->path() ?? 'cli',
                'method' => $request?->method() ?? PHP_SAPI,
            ]);
        } else {
            $this->logger->warning($exception->getMessage(), [
                'status' => $statusCode,
                'uri' => $request?->path() ?? 'cli',
            ]);
        }

        $publicMessage = $this->resolvePublicMessage($exception, $statusCode);

        if ($request !== null && $request->wantsJson()) {
            $payload = [
                'ok' => false,
                'error' => [
                    'status' => $statusCode,
                    'message' => $publicMessage,
                ],
            ];

            if ($this->debug) {
                $payload['error']['exception'] = $exception::class;
                $payload['error']['detail'] = $exception->getMessage();
            }

            return Response::json($payload, $statusCode, $headers);
        }

        $viewName = match ($statusCode) {
            404 => 'errors/404',
            405 => 'errors/405',
            default => 'errors/500',
        };

        $viewsDir = rtrim((string) config('app.paths.views', base_path('resources/views')), '/\\');
        if (is_file($viewsDir . '/' . $viewName . '.php')) {
            return Response::view($viewName, [
                'statusCode' => $statusCode,
                'message' => $publicMessage,
                'debugDetail' => $this->debug ? $exception->getMessage() : null,
                'allowedMethods' => $exception instanceof MethodNotAllowedException ? $exception->getAllowedMethods() : [],
            ], $statusCode, $headers);
        }

        return Response::html(
            '<h1>Error ' . $statusCode . '</h1><p>' . htmlspecialchars($publicMessage, ENT_QUOTES, 'UTF-8') . '</p>',
            $statusCode,
            $headers
        );
    }

    private function resolvePublicMessage(\Throwable $exception, int $statusCode): string
    {
        if ($exception instanceof HttpException && $exception->getMessage() !== '') {
            return $exception->getMessage();
        }

        if ($exception instanceof DatabaseConnectionException) {
            return 'Database service is temporarily unavailable.';
        }

        if ($this->debug && $statusCode < 500) {
            return $exception->getMessage();
        }

        return match ($statusCode) {
            404 => 'The requested page could not be found.',
            405 => 'HTTP method not allowed for this endpoint.',
            419 => 'Your session security token expired. Please refresh and try again.',
            default => 'An unexpected application error occurred.',
        };
    }
}
