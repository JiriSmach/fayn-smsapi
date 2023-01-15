<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;

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
        $method = 'statistics';
        $statisticsRequest = new StatisticsRequest();
        if ($userId) {
            $method .= '/' . $userId;
        }
        if ($from) {
            $statisticsRequest->addParam('creditHistoryFrom', $from->format(DateTimeInterface::ATOM));
        }
        if ($to) {
            $statisticsRequest->addParams('creditHistoryTo', $to->format(DateTimeInterface::ATOM));
        }

        $this->connection->getRequest($method, $statisticsRequest);
        // todo: dostat z odpovedi data a vytvorit tridu
        return [];
    }
}
