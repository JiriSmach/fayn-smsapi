<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

class Statistics
{
    private Connection $connection;

    public funxtion __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }
}
