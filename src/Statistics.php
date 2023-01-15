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
        if ($userId) {
            $method .= '/' . $userId;
        }
        $params = [];
        if ($from) {
            $params['creditHistoryFrom'] = $from->format(DateTimeInterface::ATOM);
        }
        if ($to) {
            $params['creditHistoryTo'] = $to->format(DateTimeInterface::ATOM);
        }

        $this->connection->getRequest($method, $params);
        // todo: dostat z odpovedi data a vytvorit tridu
        return [];
    }
}
