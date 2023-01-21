<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JiriSmach\FaynSmsApi\Request\SmsGetListRequest;
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
     * @return null|SmsInterface
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSms(?string $messageId = null, ?string $externalId = null): ?SmsInterface
    {
        $smsRequest = new SmsGetRequest($messageId, $externalId);
        $response = $this->connection->getRequest($smsRequest);

        return $this->createSmsFromResponse($response);
    }

    /**
     * @param DateTimeInterface|null $from
     * @param DateTimeInterface|null $to
     * @return SmsInterface[]
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSmsList(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $smsRequest = new SmsGetListRequest($from, $to);
        $response = $this->connection->getRequest($smsRequest);
        $return = [];
        foreach (($response['messages'] ?? []) as $message) {
            $return[] = $this->createSmsFromResponse($message);
        }
        return $return;
    }

    /**
     * @param array $data
     * @return SmsInterface
     */
    private function createSmsFromResponse(array $data): SmsInterface
    {
        $smsWrapper = new SmsWrapper();
        $smsWrapper->setMessageId("000275ca");
        $smsWrapper->setId("123e4567-e89b-12d3-a456-426614174000");
        $smsWrapper->setSender($data['aNumber']);
        $smsWrapper->setTextId("alphanum");
        $smsWrapper->setNumber("00420777444555");
        //$smsWrapper->setMessageType("SMS");
        $smsWrapper->setText("string");
        $smsWrapper->setPriority(true);
        $smsWrapper->setSendAt("string");
        $smsWrapper->setStatus("entered");
        $smsWrapper->setDeliveredAt("string");
        return $smsWrapper;
    }
}
