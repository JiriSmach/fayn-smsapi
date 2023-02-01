<?php

declare(strict_types=1);

namespace JiriSmach\Tests\FaynSmsApi;

use JiriSmach\FaynSmsApi\Connection;
use JiriSmach\FaynSmsApi\Sms;
use JiriSmach\FaynSmsApi\Wrappers\SmsWrapper;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testLoginException(): void
    {
        $connection = new Connection('username', 'password');

        $smsWrapper = new SmsWrapper();
        $smsWrapper->setReceiver('+420777777777');
        $smsWrapper->setText('Test text');

        $sms = new Sms($connection);

        $this->expectExceptionObject(
            new \JiriSmach\FaynSmsApi\Exceptions\LoginException(
                'Login error: Bad username or password',
                401,
            ),
        );
        $sms->sendSms([$smsWrapper]);
    }

    public function testIsLogin(): void
    {
        $connection = new Connection('username', 'password');
        $this->assertSame(false, $connection->isLogin());
    }
}
