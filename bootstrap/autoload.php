<?php

declare(strict_types=1);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

$composerAutoload = BASE_PATH . '/vendor/autoload.php';
if (is_file($composerAutoload)) {
    require_once $composerAutoload;
    return;
}

if (!defined('NATIVE_PSR4_AUTOLOADER_REGISTERED')) {
    define('NATIVE_PSR4_AUTOLOADER_REGISTERED', true);

    spl_autoload_register(static function (string $class): void {
        $prefixes = [
            'App\\' => BASE_PATH . '/app/',
            'Core\\' => BASE_PATH . '/core/',
        ];

        foreach ($prefixes as $prefix => $baseDir) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }

            $relativeClass = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (is_file($file)) {
                require_once $file;
            }
            return;
        }
    });
}

$helpersFile = BASE_PATH . '/core/Helpers/functions.php';
if (is_file($helpersFile)) {
    require_once $helpersFile;
}

