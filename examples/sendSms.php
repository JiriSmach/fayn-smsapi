<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$smsWrapper = new \JiriSmach\FaynSmsApi\SmsWrapper();
$smsWrapper->setNumbers(['777777777', '666666666']);
$smsWrapper->setText('Test text');

$sms = new \JiriSmach\FaynSmsApi\Sms($connection);
$sms->sendSms($smsWrapper);