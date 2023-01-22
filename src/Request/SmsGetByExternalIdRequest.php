<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

class SmsGetByExternalIdRequest extends SmsRequest
{
    private string $externalId;

    public function __construct(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getPath(): string
    {
        return parent::getPath().'by-external-id/'.$this->externalId;
    }

    /**
     * @return array
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
