<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\RequestInterface;

class BulkChangeRequest implements RequestInterface
{
    private string $action;
    private array $messageIds;

    public function __construct(string $action, array $messageIds)
    {
        $this->action = $action;
        $this->messageIds = $messageIds;
    }

    public function getBodyJson(): string
    {
        return Utils::jsonEncode([
            'messageIds' => $this->messageIds,
            'action' => $this->action
        ]);
    }

    public function getMethod(): string
    {
        return 'received-sms/bulk-change';
    }

    public function getUrlParams(): array
    {
        return [];
    }
}
