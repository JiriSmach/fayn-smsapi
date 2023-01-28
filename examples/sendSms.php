<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$smsWrapper = new \JiriSmach\FaynSmsApi\Wrappers\SmsWrapper();
$smsWrapper->setReceiver('+420777777777');
$smsWrapper->setSender('+420777555333');
$smsWrapper->setSendAt(new \DateTime());
$smsWrapper->setText('testovaci sms');
$smsWrapper->setId('test-1');

$sms = new \JiriSmach\FaynSmsApi\Sms($connection);
try {
    $sms->sendSms([$smsWrapper]);
} catch (\Throwable $e) {
    var_dump($e->getMessage());
}
