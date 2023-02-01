<?php

declare(strict_types=1);

namespace JiriSmach\Tests\FaynSmsApi\Helpers;

use JiriSmach\FaynSmsApi\Helpers\Numbers;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testValidatePhoneNumberException(): void
    {
        $numbers = new Numbers();
        $this->assertSame($numbers->validatePhoneNumber('00420777777777'), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('+420777777777'), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('+420777777777', [420]), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('00420777777777', [420]), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('+91-202-5555-0234'), '009120255550234');
        $this->assertSame($numbers->validatePhoneNumber('+420 777 777 777'), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('+420 777 77 77 77'), '00420777777777');
        $this->assertSame($numbers->validatePhoneNumber('+1(415) 555-2671'), '0014155552671');
        $this->assertSame($numbers->validatePhoneNumber('+81-426-32-8510'), '0081426328510');
        $this->assertSame($numbers->validatePhoneNumber('+257 430 5019'), '002574305019');

        $this->expectException(\InvalidArgumentException::class);
        $numbers->validatePhoneNumber('+420 aaa aaa aaa');
        $numbers->validatePhoneNumber('+420 777 # 777 777');
        $numbers->validatePhoneNumber('+257 430 5019', [420]);
        $numbers->validatePhoneNumber('(415) 555-2671');
    }
}
