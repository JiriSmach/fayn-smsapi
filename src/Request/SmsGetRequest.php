<?php

namespace JiriSmach\FaynSmsApi\Request;

class SmsGetRequest extends SmsRequest
{
    private ?string $messageId;
    private ?string $externalId;
    private array $urlParams = [];
    public function __construct(?string $messageId = null, ?string $externalId = null)
    {
        $this->messageId = $messageId;
        $this->externalId = $externalId;
    }

    public function getMethod(): string
    {
        if ($this->messageId) {
            return parent::getMethod() . '/' . $this->messageId;
        } elseif ($this->externalId) {
            return parent::getMethod() . '/by-external-id/' . $this->externalId;
        }
        return parent::getMethod() . '/list';
    }

    public function addUrlParam(string $key, string $param): self
    {
        $this->urlParams[$key] = $param;
        return $this;
    }

    public function getUrlParams(): array
    {
        return [];
    }

    public function getBodyJson(): string
    {
        return '';
    }
}
