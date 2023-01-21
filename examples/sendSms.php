<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$smsWrapper = new \JiriSmach\FaynSmsApi\Wrappers\SmsWrapper();
$smsWrapper->setReceiver('777777777');
$smsWrapper->setText('Test text');

$sms = new \JiriSmach\FaynSmsApi\Sms($connection);
try {
    $sms->sendSms([$smsWrapper]);
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
