<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use JiriSmach\FaynSmsApi\RequestInterface;

class StatisticsRequest implements RequestInterface
{
    private array $urlParams = [];
    private ?int $userId;

    public function __construct(?int $userId)
    {
        $this->userId = $userId;
    }

    public function getBodyJson(): string
    {
        return '';
    }

    public function getPath(): string
    {
        $method = 'statistics';
        if ($this->userId) {
            $method .= '/' . $this->userId;
        }
        return $method;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function addUrlParam(string $key, string $param): self
    {
        $this->urlParams[$key] = $param;
        return $this;
    }

    public function getMethod(): string
    {
        return self::METHOD_GET;
    }
}
