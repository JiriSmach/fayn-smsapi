<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JiriSmach\FaynSmsApi\Request\SmsGetRequest;
use JiriSmach\FaynSmsApi\Request\SmsSendRequest;

class Sms
{
    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @param SmsInterface $smsInterface
     * @return 
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function sendSms(SmsInterface $smsInterface): void
    {
        $smsRequest = new SmsSendRequest($smsInterface);
        $this->connection->postRequest($smsRequest);
    }

    /**
     * @param null|string $messageId
     * @param null|string $externalId
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSms(?string $messageId = null, ?string $externalId = null): SmsData
    {
        $smsRequest = new SmsGetRequest($messageId, $externalId);
        $this->connection->getRequest($smsRequest);

        $smsData = new SmsData();
        return $smsData;
    }

    /**
     * @param DateTimeInterface|null $from
     * @param DateTimeInterface|null $to
     * @return SmsData[]
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSmsList(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $smsRequest = new SmsGetRequest();
        if ($from) {
            $smsRequest->addUrlParam('timeFrom', $from->format(DateTimeInterface::ATOM));
        }
        if ($to) {
            $smsRequest->addUrlParam('timeTo', $to->format(DateTimeInterface::ATOM));
        }
        $this->connection->getRequest($smsRequest);
        return [];
    }
}
