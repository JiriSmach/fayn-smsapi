<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

class SmsGetByIdRequest extends SmsRequest
{
    private string $messageId;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    public function getPath(): string
    {
        return parent::getPath() . $this->messageId;
    }

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array
    {
        return [];
    }

    public function getBodyJson(): string
    {
        return '';
    }

    public function getMethod(): string
    {
        return self::METHOD_GET;
    }
}
