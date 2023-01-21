<?php

namespace JiriSmach\Tests\FaynSmsApi;

use JiriSmach\FaynSmsApi\Exceptions\LoginException;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testLoginException()
    {
        $connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

        $smsWrapper = new \JiriSmach\FaynSmsApi\Wrappers\SmsWrapper();
        $smsWrapper->setReciever('+420777777777');
        $smsWrapper->setText('Test text');

        $sms = new \JiriSmach\FaynSmsApi\Sms($connection);

        $this->expectExceptionObject(new LoginException('Login error: Bad username or password', 401));
        $sms->sendSms([$smsWrapper]);
    }

    public function testIsLogin()
    {
        $connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');
        $this->assertSame(false, $connection->isLogin());
    }
}