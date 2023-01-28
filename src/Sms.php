<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Request\SmsGetByExternalIdRequest;
use JiriSmach\FaynSmsApi\Request\SmsGetByIdRequest;
use JiriSmach\FaynSmsApi\Request\SmsGetListRequest;
use JiriSmach\FaynSmsApi\Request\SmsSendRequest;
use JiriSmach\FaynSmsApi\Wrappers\SmsWrapper;

class Sms
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  SmsInterface[] $smsInterface
     * @throws \JiriSmach\FaynSmsApi\Exceptions\LoginException
     * @throws GuzzleException
     */
    public function sendSms(array $smsInterface): SmsWrapper
    {
        $smsRequest = new SmsSendRequest($smsInterface);
        $response = $this->connection->doRequest($smsRequest);

        $responseArray = Utils::jsonDecode(
            $response->getBody()?->getContents() ?: '',
            true,
        );

        return $this->createSmsFromResponse($responseArray);
    }

    /**
     * @param  string $messageId
     * @return SmsInterface|null
     * @throws \JiriSmach\FaynSmsApi\Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSmsById(string $messageId): ?SmsInterface
    {
        $smsRequest = new SmsGetByIdRequest($messageId);
        $response = $this->connection->doRequest($smsRequest);
        $responseArray = Utils::jsonDecode(
            $response->getBody()?->getContents() ?: '',
            true,
        );

        return $this->createSmsFromResponse($responseArray);
    }

    /**
     * @param  string $externalId
     * @return SmsInterface|null
     * @throws \JiriSmach\FaynSmsApi\Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSmsByExternalId(string $externalId): ?SmsInterface
    {
        $smsRequest = new SmsGetByExternalIdRequest($externalId);
        $response = $this->connection->doRequest($smsRequest);
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);

        return $this->createSmsFromResponse($responseArray);
    }

    /**
     * @param  DateTimeInterface|null $from
     * @param  DateTimeInterface|null $to
     * @return SmsInterface[]
     * @throws \JiriSmach\FaynSmsApi\Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getSmsList(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $smsRequest = new SmsGetListRequest($from, $to);
        $response = $this->connection->doRequest($smsRequest);
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        $return = [];
        foreach (($responseArray['messages'] ?? []) as $message) {
            $return[] = $this->createSmsFromResponse($message);
        }

        return $return;
    }

    /**
     * @param  array<string, mixed> $data
     * @return SmsInterface
     */
    private function createSmsFromResponse(array $data): SmsInterface
    {
        $smsWrapper = new SmsWrapper();
        $smsWrapper->setMessageId($data['messageId'] ?? '');
        $smsWrapper->setId($data['externalId'] ?? '');
        $smsWrapper->setSender($data['aNumber'] ?? '');
        $smsWrapper->setTextId($data['textId'] ?? '');
        $smsWrapper->setReceiver($data['bNumber'] ?? '');
        $smsWrapper->setText($data['text'] ?? '');
        $smsWrapper->setPriority($data['priority'] ?? '');
        $smsWrapper->setSendAt($data['sendAt'] ?? '');
        $smsWrapper->setStatus($data['status'] ?? '');
        $smsWrapper->setDeliveredAt($data['deliveredAt'] ?? '');

        return $smsWrapper;
    }
}
