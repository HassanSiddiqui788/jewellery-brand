<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\ValidationException;
use App\Validators\CatalogQueryValidator;
use Core\Helpers\Security;
use Core\Logging\Logger;
use Core\Session\SessionManager;
use Tests\Assert;

final class SecurityAndLoggingTest
{
    public function testSessionHardeningCookieConfiguration(): void
    {
        $session = new SessionManager([
            'name' => 'bijoux_session',
            'lifetime' => 90,
            'http_only' => true,
            'same_site' => 'Lax',
            'secure' => 'auto',
        ]);

        $httpOptions = $session->getCookieOptions(false);
        Assert::same(5400, $httpOptions['lifetime']);
        Assert::true($httpOptions['httponly']);
        Assert::same('Lax', $httpOptions['samesite']);
        Assert::false($httpOptions['secure']);

        $httpsOptions = $session->getCookieOptions(true);
        Assert::true($httpsOptions['secure']);
    }

    public function testLoggerSecretRedaction(): void
    {
        $tmpLog = sys_get_temp_dir() . '/bijoux_log_test_' . bin2hex(random_bytes(4)) . '.log';
        $logger = new Logger($tmpLog, 'debug');

        try {
            $logger->error('Connection failed for mysql://admin:TopSecret99@localhost/jewels_db', [
                'password' => 'TopSecret99',
                'csrf_token' => 'abc123secret',
                'safe_field' => 'necklaces',
            ]);

            $written = (string) file_get_contents($tmpLog);
            Assert::notContains('TopSecret99', $written);
            Assert::notContains('abc123secret', $written);
            Assert::contains('[REDACTED]', $written);
            Assert::contains('necklaces', $written);
        } finally {
            @unlink($tmpLog);
        }
    }

    public function testEscapingAndValidatorBehavior(): void
    {
        Assert::same('&lt;script&gt;alert(1)&lt;/script&gt;', Security::escapeHtml('<script>alert(1)</script>'));
        Assert::same('#', Security::escapeUrl('javascript:alert(1)'));
        Assert::same('golden-necklace-1', Security::sanitizeSlug(' Golden Necklace #1! '));

        $validator = new CatalogQueryValidator();
        $clean = $validator->validate(['category' => 'Necklaces', 'q' => '<b>Gold</b>', 'sort' => 'price_asc', 'limit' => '12']);
        Assert::same('necklaces', $clean['category']);
        Assert::same('Gold', $clean['search']);
        Assert::same('price_asc', $clean['sort']);
        Assert::same(12, $clean['limit']);

        Assert::throws(ValidationException::class, static function () use ($validator): void {
            $validator->validate(['sort' => 'invalid_sort', 'limit' => 500]);
        });
    }
}

