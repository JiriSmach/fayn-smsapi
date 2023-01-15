<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use GuzzleHttp\Exception\GuzzleException;
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
    public function getList()
    {
        $this->connection->getRequest();
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