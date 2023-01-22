<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\SmsInterface;

class SmsSendRequest extends SmsRequest
{
    private array $sms;

    /**
     * @param SmsInterface[] $sms
     */
    public function __construct(array $sms)
    {
        $this->sms = $sms;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath().'/send';
    }

    /**
     * @return string
     */
    public function getBodyJson(): string
    {
        $array = [];
        foreach ($this->sms as $sms) {
            $array[] = $sms->getData();
        }

        return Utils::jsonEncode($array);
    }

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }
}
