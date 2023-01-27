<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

class MarkAsReadRequest implements RequestInterface
{
    /** @var string<string, string> */
    private string $messageId;

    /**
     * @param string<string, string> $messageId
     */
    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    public function getBodyJson(): string
    {
        return '';
    }

    public function getPath(): string
    {
        return 'received-sms/' . $this->messageId . '/markAsRead';
    }

    /**
     * @return array<string, string>
     */
    public function getUrlParams(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return self::METHOD_PATCH;
    }
}
