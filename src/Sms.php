<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Request\SmsGetListRequest;
use JiriSmach\FaynSmsApi\Request\SmsGetRequest;
use JiriSmach\FaynSmsApi\Request\SmsSendRequest;
use JiriSmach\FaynSmsApi\Wrappers\SmsWrapper;

class Sms
{
    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @param SmsInterface[] $smsInterface
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function sendSms(array $smsInterface): void
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
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        return $this->createSmsFromResponse($responseArray);
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
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        $return = [];
        foreach (($responseArray['messages'] ?? []) as $message) {
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
        $smsWrapper->setMessageId($data['messageId'] ?? '');
        $smsWrapper->setId($data['externalId'] ?? '');
        $smsWrapper->setSender($data['aNumber'] ?? '');
        $smsWrapper->setTextId($data['textId'] ?? '');
        $smsWrapper->setReceiver($data['bNumber'] ?? '');
        $smsWrapper->setText($data['text'] ?? '');
        $smsWrapper->setPriority($data['priority'] ?? '');
        $smsWrapper->setSendAt($data['sendAt'] ?? '');
        $smsWrapper->setStatus($data['status'] ?? '');
        $smsWrapper->setDeliveredAt( $data['deliveredAt'] ?? '');
        return $smsWrapper;
    }
}
