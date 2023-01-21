<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface SmsInterface
{
    public const SMS_TYPE = 'SMS';

    public const TYPES = [
        self::SMS_TYPE,
    ];

    public function getData(): array;
}
