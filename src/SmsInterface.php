<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface SmsInterface
{
    public const SMS_TYPE = 'SMS';
    public const TYPES = [
        self::SMS_TYPE,
    ];

    /**
     * @return array<string, string>
     */
    public function getData(): array;

    public function getId(): ?string;
}
