<?php

declare(strict_types=1);

namespace Tests\Integration;

use Core\Application;
use Core\Http\Request;
use Tests\Assert;

final class ApplicationSmokeTest
{
    public function testBootAndHttpDispatchLifecycle(): void
    {
        require_once BASE_PATH . '/bootstrap/app.php';

        Application::setInstance(null);
        $app = app_bootstrap(false);

        $homeRes = $app->handleHttp(new Request('GET', '/'));
        Assert::same(200, $homeRes->getStatusCode());
        Assert::same('nosniff', $homeRes->getHeader('X-Content-Type-Options'));
        Assert::contains('Lorem Ipsum', $homeRes->getContent());

        $healthRes = $app->handleHttp(new Request('GET', '/api/v1/health'));
        Assert::true(in_array($healthRes->getStatusCode(), [200, 503], true));
        $healthPayload = json_decode($healthRes->getContent(), true);
        Assert::true(is_array($healthPayload) && array_key_exists('data', $healthPayload));
        Assert::notContains((string) env('DB_PASSWORD', '@hassan123'), $healthRes->getContent());

        $notFoundRes = $app->handleHttp(new Request('GET', '/route-that-does-not-exist'));
        Assert::same(404, $notFoundRes->getStatusCode());

        $methodNotAllowedRes = $app->handleHttp(new Request('DELETE', '/health'));
        Assert::same(405, $methodNotAllowedRes->getStatusCode());
        Assert::contains('GET', (string) $methodNotAllowedRes->getHeader('Allow'));

        $validationRes = $app->handleHttp(new Request('GET', '/api/v1/products', query: ['sort' => 'hacked']));
        Assert::same(422, $validationRes->getStatusCode());
    }

    public function testBackwardCompatibilityBridges(): void
    {
        require_once BASE_PATH . '/includes/config.php';
        require_once BASE_PATH . '/admin/includes/config.php';

        Assert::true(defined('LOREM_APP'));
        Assert::true(defined('BIJOUX_APP'));
        Assert::true(defined('SITE_NAME'));
        Assert::true(defined('DB_NAME'));
        Assert::same('jewels_db', DB_NAME);
        Assert::true(function_exists('get_db_connection'));
        Assert::true(function_exists('is_db_connected'));
        Assert::true(function_exists('get_db_error'));
        Assert::true(function_exists('get_pdo_connection'));
        Assert::true(function_exists('site_url'));
        Assert::true(function_exists('e'));
        Assert::true(defined('ADMIN_APP'));
        Assert::true(function_exists('get_admin_nav_items'));
        Assert::true(function_exists('admin_currency'));
    }

    public function testLegacyStorefrontAndAdminEntrypointsRenderWithoutErrors(): void
    {
        $renderCheck = static function (string $relativeFile, string $expectedNeedle): void {
            $script = sprintf(
                'error_reporting(E_ALL); ob_start(); require %s; $out = ob_get_clean(); echo strlen($out) . "|" . (str_contains($out, %s) ? "OK" : "MISSING");',
                var_export(BASE_PATH . '/' . $relativeFile, true),
                var_export($expectedNeedle, true)
            );

            $cmd = PHP_BINARY . ' -r ' . escapeshellarg($script);
            $output = [];
            $exitCode = 0;
            exec($cmd, $output, $exitCode);

            $joined = implode("\n", $output);
            Assert::same(0, $exitCode, "Entrypoint {$relativeFile} failed: {$joined}");
            Assert::contains('|OK', $joined, "Entrypoint {$relativeFile} missing expected marker.");
        };

        $renderCheck('index.php', '<html');
        $renderCheck('shop/index.php', '<html');
        $renderCheck('admin/index.php', 'Dashboard');
    }
}
