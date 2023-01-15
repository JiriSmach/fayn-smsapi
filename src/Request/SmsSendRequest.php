<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\SmsInterface;

class SmsSendRequest extends SmsRequest
{
    private SmsInterface $sms;

    public function __construct(SmsInterface $sms)
    {
        $this->sms = $sms;
    }
    public function getMethod(): string
    {
        return parent::getMethod() . '/send';
    }

    public function getBodyJson(): string
    {
        return Utils::jsonEncode([$this->sms->getData()]);
    }
}