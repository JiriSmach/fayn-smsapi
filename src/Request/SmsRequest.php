<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\RequestInterface;

class SmsRequest implements RequestInterface
{

    /**
     * @return string
     */
    public function getBodyJson(): string
    {
        return '';
    }

    public function getUrlParams(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return 'sms';
    }
}
