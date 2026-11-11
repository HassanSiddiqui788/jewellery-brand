#!/usr/bin/env php
<?php

declare(strict_types=1);

use Tests\AssertionFailed;
use Tests\Integration\ApplicationSmokeTest;
use Tests\SkippedTest;
use Tests\Unit\ConfigAndEnvTest;
use Tests\Unit\DatabaseLayerTest;
use Tests\Unit\RouterAndMiddlewareTest;
use Tests\Unit\SecurityAndLoggingTest;

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require dirname(__DIR__) . '/bootstrap/autoload.php';
require_once __DIR__ . '/Assert.php';

$suites = [
    ConfigAndEnvTest::class,
    DatabaseLayerTest::class,
    RouterAndMiddlewareTest::class,
    SecurityAndLoggingTest::class,
    ApplicationSmokeTest::class,
];

$passed = 0;
$failed = 0;
$skipped = 0;

echo "Running Bijoux Backend Architecture Test Suite...\n";
echo str_repeat('=', 60) . "\n";

foreach ($suites as $suiteClass) {
    $instance = new $suiteClass();
    $methods = get_class_methods($instance);

    foreach ($methods as $method) {
        if (!str_starts_with($method, 'test')) {
            continue;
        }

        $label = $suiteClass . '::' . $method;
        try {
            $instance->{$method}();
            $passed++;
            echo sprintf("[PASS] %s\n", $label);
        } catch (SkippedTest $e) {
            $skipped++;
            echo sprintf("[SKIP] %s — %s\n", $label, $e->getMessage());
        } catch (\Throwable $e) {
            $failed++;
            $kind = $e instanceof AssertionFailed ? 'FAIL' : 'ERROR';
            echo sprintf("[%s] %s — %s (%s:%d)\n", $kind, $label, $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}

echo str_repeat('=', 60) . "\n";
echo sprintf("Summary: %d passed, %d skipped, %d failed\n", $passed, $skipped, $failed);

exit($failed > 0 ? 1 : 0);
