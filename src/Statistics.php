<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JiriSmach\FaynSmsApi\Request\StatisticsRequest;
use JiriSmach\FaynSmsApi\Wrappers\StatisticsDataWrapper;

class Statistics
{
    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @param DateTimeInterface|null $from
     * @param DateTimeInterface|null $to
     * @param int|null $userId
     * @return StatisticsDataWrapper
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getStatistics(?DateTimeInterface $from = null, ?DateTimeInterface $to = null, ?int $userId = null): StatisticsDataWrapper
    {
        $statisticsRequest = new StatisticsRequest($userId);
        if ($from) {
            $statisticsRequest->addUrlParam('creditHistoryFrom', $from->format(DateTimeInterface::ATOM));
        }
        if ($to) {
            $statisticsRequest->addUrlParam('creditHistoryTo', $to->format(DateTimeInterface::ATOM));
        }

        $this->connection->getRequest($statisticsRequest);
        // todo: dostat z odpovedi data a vytvorit tridu
        return new StatisticsDataWrapper();
    }
}
