<?php

declare(strict_types=1);

namespace Core\Logging;

/**
 * Centralized, secret-redacting file logger writing structured entries to storage/logs.
 */
final class Logger
{
    private const LEVELS = [
        'debug' => 100,
        'info' => 200,
        'notice' => 250,
        'warning' => 300,
        'error' => 400,
        'critical' => 500,
        'alert' => 550,
        'emergency' => 600,
    ];

    private const SENSITIVE_KEY_PATTERN = '/pass(word)?|pwd|secret|token|csrf|api[_-]?key|auth(orization)?|cookie|private[_-]?key|dsn/i';

    private string $logFile;
    private int $minLevel;

    public function __construct(string $logFile, string $minLevel = 'debug')
    {
        $this->logFile = $logFile;
        $this->minLevel = self::LEVELS[strtolower($minLevel)] ?? self::LEVELS['debug'];
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    public function notice(string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    public function exception(\Throwable $exception, array $context = []): void
    {
        $context['exception'] = [
            'class' => $exception::class,
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $this->redactString($exception->getMessage()),
        ];

        $this->error($exception->getMessage(), $context);
    }

    public function log(string $level, string $message, array $context = []): void
    {
        $normalizedLevel = strtolower($level);
        $severity = self::LEVELS[$normalizedLevel] ?? self::LEVELS['info'];

        if ($severity < $this->minLevel) {
            return;
        }

        $directory = dirname($this->logFile);
        if (!is_dir($directory)) {
            @mkdir($directory, 0775, true);
        }

        if (!is_dir($directory) || !is_writable($directory)) {
            return;
        }

        $safeMessage = $this->redactString($message);
        $safeContext = $this->redactValue($context);
        $contextJson = $safeContext === []
            ? ''
            : ' ' . (json_encode($safeContext, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}');

        $entry = sprintf(
            "[%s] [%s] %s%s%s",
            gmdate('Y-m-d H:i:s') . ' UTC',
            strtoupper($normalizedLevel),
            $safeMessage,
            $contextJson,
            PHP_EOL
        );

        @file_put_contents($this->logFile, $entry, FILE_APPEND | LOCK_EX);
    }

    public function getLogFile(): string
    {
        return $this->logFile;
    }

    private function redactValue(mixed $value): mixed
    {
        if (is_array($value)) {
            $clean = [];
            foreach ($value as $k => $v) {
                if (is_string($k) && preg_match(self::SENSITIVE_KEY_PATTERN, $k) === 1) {
                    $clean[$k] = '[REDACTED]';
                } else {
                    $clean[$k] = $this->redactValue($v);
                }
            }
            return $clean;
        }

        if (is_string($value)) {
            return $this->redactString($value);
        }

        if ($value instanceof \Throwable) {
            return [
                'class' => $value::class,
                'message' => $this->redactString($value->getMessage()),
                'file' => $value->getFile(),
                'line' => $value->getLine(),
            ];
        }

        if (is_object($value)) {
            return '[object ' . $value::class . ']';
        }

        return $value;
    }

    private function redactString(string $input): string
    {
        // Mask DSN credentials or inline key=value secrets
        $sanitized = preg_replace('/([a-zA-Z][a-zA-Z0-9+.-]*:\/\/[^:\s\/]+:)([^@\s]+)(@)/', '$1[REDACTED]$3', $input) ?? $input;
        $sanitized = preg_replace('/\b(password|passwd|pwd|secret|token|api_key)\s*=\s*[^\s;,&]+/i', '$1=[REDACTED]', $sanitized) ?? $sanitized;

        // Mask configured DB password literal if non-trivial
        $dbPassword = $_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? '';
        if (is_string($dbPassword) && strlen($dbPassword) >= 4) {
            $sanitized = str_replace($dbPassword, '[REDACTED]', $sanitized);
        }

        return $sanitized;
    }
}

