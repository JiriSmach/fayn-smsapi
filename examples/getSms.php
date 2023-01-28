<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$sms = new \JiriSmach\FaynSmsApi\Sms($connection);
try {
    $list = $sms->getSmsList();
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
