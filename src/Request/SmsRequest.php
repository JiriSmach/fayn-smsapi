<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

abstract class SmsRequest implements RequestInterface
{
    /** @var array<string, array<string, mixed>> */
    protected array $data = [];

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
        return 'sms/';
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getData(): array
    {
        return $this->data;
    }
}
