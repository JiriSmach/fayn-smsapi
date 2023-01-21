<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Request\BulkChangeRequest;
use JiriSmach\FaynSmsApi\Request\MarkAsReadRequest;
use JiriSmach\FaynSmsApi\Request\ReceivedSmsListRequest;
use JiriSmach\FaynSmsApi\Wrappers\SmsWrapper;

class ReceivedSms
{

    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @param int|null $pageSize
     * @param int|null $page
     * @param DateTimeInterface|null $dateFrom
     * @param DateTimeInterface|null $dateTo
     * @param int|null $messageId
     * @param string|null $id
     * @param string|null $source
     * @param int|null $cid
     * @return SmsWrapper[]
     * @throws GuzzleException
     */
    public function getList(
        ?int $pageSize,
        ?int $page,
        ?DateTimeInterface $dateFrom,
        ?DateTimeInterface $dateTo,
        ?int $messageId,
        ?string $id,
        ?string $source,
        ?int $cid
    ): array {
        $receivedSmsRequest = new ReceivedSmsListRequest(
            $pageSize,
            $page,
            $dateFrom,
            $dateTo,
            $messageId,
            $id,
            $source,
            $cid
        );
        $response = $this->connection->getRequest($receivedSmsRequest);
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        $return = [];
        foreach (($responseArray['messages'] ?? []) as $message) {
            $return[] = $this->createSmsFromResponse($message);
        }
        return $return;
    }

    /**
     * @param string $messageId
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function markAsRead(string $messageId): void
    {
        $markAsReadRequest = new MarkAsReadRequest($messageId);
        $this->connection->patchRequest($markAsReadRequest);
    }

    /**
     * @param array $messageIds
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function makrsAsRead(array $messageIds): void
    {
        $bulkChangeRequest = new BulkChangeRequest('markAsRead', $messageIds);
        $this->connection->postRequest($bulkChangeRequest);
    }

    /**
     * @param array $data
     * @return SmsInterface
     */
    private function createSmsFromResponse(array $data): SmsInterface
    {
        $smsWrapper = new SmsWrapper();
        $smsWrapper->setMessageId($data['messageId'] ?? '');
        $smsWrapper->setSender($data['aNumber'] ?? '');
        $smsWrapper->setTextId($data['textId'] ?? '');
        $smsWrapper->setReceiver($data['bNumber'] ?? '');
        $smsWrapper->setText($data['text'] ?? '');
        $smsWrapper->setReceivedAt($data['receivedAt'] ?? '');
        $smsWrapper->setRead($data['read'] ?? '');
        return $smsWrapper;
    }
}
