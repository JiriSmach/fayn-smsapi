<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

class MarkAsReadRequest implements RequestInterface
{
    private array $messageId;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    public function getBodyJson(): string
    {
        return '';
    }

    public function getMethod(): string
    {
        return 'received-sms/'. $this->messageId . '/markAsRead';
    }

    public function getUrlParams(): array
    {
        return [];
    }
}
