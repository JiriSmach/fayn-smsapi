<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JiriSmach\FaynSmsApi\Request\ReceivedSmsListRequest;
use JiriSmach\FaynSmsApi\Request\SmsRequest;

class ReceivedSms
{

    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @throws Exceptions\LoginException
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
    ) {
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
        $this->connection->getRequest($receivedSmsRequest);
    }

    /**
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function markAsRead()
    {
        $this->connection->patchRequest();
    }

    /**
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function makrsAsRead()
    {
        $this->connection->postRequest();
    }
}