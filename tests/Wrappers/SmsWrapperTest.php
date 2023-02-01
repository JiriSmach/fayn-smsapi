<?php

declare(strict_types=1);

namespace JiriSmach\Tests\FaynSmsApi\Wrappers;

use JiriSmach\FaynSmsApi\Wrappers\SmsWrapper;
use PHPUnit\Framework\TestCase;

class SmsWrapperTest extends TestCase
{
    public function testSmsWrapper(): void
    {
        $smsWrapper = new SmsWrapper();
        $this->assertSame($smsWrapper->getData(), [
            'bNumber' => '',
            'messageType' => 'SMS',
            'text' => '',
            'priority' => false,
            'sendAt' => '',
            'externalId' => null,
        ]);

        $smsWrapper = new SmsWrapper();
        $smsWrapper->setId('test_own_id');
        $this->assertSame($smsWrapper->getData(), [
            'bNumber' => '',
            'messageType' => 'SMS',
            'text' => '',
            'priority' => false,
            'sendAt' => '',
            'externalId' => 'test_own_id',
        ]);
    }
}
