<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JiriSmach\FaynSmsApi\Request\StatisticsRequest;

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
    public function sendSms(SmsInterface $smsInterface)
    {
        $smsRequest = new SmsRequest();
        $this->connection->postRequest($smsRequest);
    }

    public function getSms()
    {
        $this->connection->getRequest();
    }

    public function getSmsList()
    {
        $this->connection->getRequest();
    }
}
