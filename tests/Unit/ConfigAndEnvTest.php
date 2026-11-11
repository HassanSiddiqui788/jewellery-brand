<?php

declare(strict_types=1);

namespace Tests\Unit;

use Core\Config\ConfigRepository;
use Core\Config\EnvLoader;
use Tests\Assert;

final class ConfigAndEnvTest
{
    public function testPsr4Autoloading(): void
    {
        Assert::true(class_exists(\Core\Application::class));
        Assert::true(class_exists(\Core\Database\Connection::class));
        Assert::true(class_exists(\Core\Router\Router::class));
        Assert::true(class_exists(\App\Controllers\HealthController::class));
        Assert::true(class_exists(\App\Services\CatalogService::class));
        Assert::true(class_exists(\App\Repositories\ProductRepository::class));
    }

    public function testEnvLoaderParsing(): void
    {
        $tmpEnv = sys_get_temp_dir() . '/bijoux_test_' . bin2hex(random_bytes(4)) . '.env';
        file_put_contents($tmpEnv, implode(PHP_EOL, [
            '# Comment line',
            'TEST_APP_NAME="Bijoux Atelier"',
            "TEST_SINGLE_QUOTE='hello # world'",
            'TEST_BOOL_TRUE=true',
            'TEST_BOOL_FALSE=false',
            'TEST_NULL_VAL=null',
            'TEST_INLINE=local # inline comment',
        ]));

        try {
            Assert::true(EnvLoader::load($tmpEnv, true));
            Assert::same('Bijoux Atelier', EnvLoader::get('TEST_APP_NAME'));
            Assert::same('hello # world', EnvLoader::get('TEST_SINGLE_QUOTE'));
            Assert::same(true, EnvLoader::get('TEST_BOOL_TRUE'));
            Assert::same(false, EnvLoader::get('TEST_BOOL_FALSE'));
            Assert::same(null, EnvLoader::get('TEST_NULL_VAL'));
            Assert::same('local', EnvLoader::get('TEST_INLINE'));
        } finally {
            @unlink($tmpEnv);
            unset(
                $_ENV['TEST_APP_NAME'],
                $_SERVER['TEST_APP_NAME'],
                $_ENV['TEST_SINGLE_QUOTE'],
                $_SERVER['TEST_SINGLE_QUOTE'],
                $_ENV['TEST_BOOL_TRUE'],
                $_SERVER['TEST_BOOL_TRUE'],
                $_ENV['TEST_BOOL_FALSE'],
                $_SERVER['TEST_BOOL_FALSE'],
                $_ENV['TEST_NULL_VAL'],
                $_SERVER['TEST_NULL_VAL'],
                $_ENV['TEST_INLINE'],
                $_SERVER['TEST_INLINE']
            );
        }
    }

    public function testCentralConfigRepositoryLoadsWithoutLegacyDbScript(): void
    {
        EnvLoader::load(BASE_PATH . '/.env', false);
        $config = ConfigRepository::loadFromPath(BASE_PATH . '/config');

        Assert::same('jewels_db', $config->get('database.connections.mysql.database'));
        Assert::same('mysql', $config->get('database.default'));
        Assert::same(3306, $config->get('database.connections.mysql.port'));
        Assert::true($config->has('session.http_only'));
        Assert::false($config->has('db'));
    }
}
