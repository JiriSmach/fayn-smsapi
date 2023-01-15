<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\RequestInterface;

abstract class SmsRequest implements RequestInterface
{
    abstract public function getBodyJson(): string;

    public function getUrlParams(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return 'sms';
    }
}
