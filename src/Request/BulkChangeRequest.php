<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\RequestInterface;

class BulkChangeRequest implements RequestInterface
{
    private string $action;

    /** @var array<string, string> */
    private array $messageIds;

    /**
     * @param string                $action
     * @param array<string, string> $messageIds
     */
    public function __construct(string $action, array $messageIds)
    {
        $this->action = $action;
        $this->messageIds = $messageIds;
    }

    public function getBodyJson(): string
    {
        return Utils::jsonEncode([
            'messageIds' => $this->messageIds,
            'action' => $this->action,
        ]);
    }

    public function getPath(): string
    {
        return 'received-sms/bulk-change';
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
        return self::METHOD_POST;
    }
}
