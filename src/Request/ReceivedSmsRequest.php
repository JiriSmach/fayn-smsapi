<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

abstract class ReceivedSmsRequest implements RequestInterface
{
    abstract public function getBodyJson(): string;

    abstract public function getMethod(): string;

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return 'received-sms/';
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getData(): array
    {
        return [];
    }
}
