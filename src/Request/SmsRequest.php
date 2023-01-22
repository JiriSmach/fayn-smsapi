<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

abstract class SmsRequest implements RequestInterface
{
    abstract public function getBodyJson(): string;

    abstract public function getMethod(): string;
    public function getUrlParams(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return 'sms/';
    }
}
