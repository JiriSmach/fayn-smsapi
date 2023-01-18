<?php

namespace JiriSmach\FaynSmsApi\Request;

class SmsGetListRequest extends SmsRequest
{
    private ?string $messageId;
    private ?string $externalId;

    public function __construct(?string $messageId = null, ?string $externalId = null)
    {
    }

    public function getMethod(): string
    {
        return parent::getMethod() . '/list';
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
}
