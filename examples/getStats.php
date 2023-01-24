<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$stats = new JiriSmach\FaynSmsApi\Statistics($connection);

try {
    $statistics = $stats->getStatistics();
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
