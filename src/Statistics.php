<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use JiriSmach\FaynSmsApi\Request\StatisticsRequest;

class Statistics
{
    private Connection $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    public function getStatistics(?DateTimeInterface $from = null, ?DateTimeInterface $to = null, ?int $userId = null): array
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
        return [];
    }
}
