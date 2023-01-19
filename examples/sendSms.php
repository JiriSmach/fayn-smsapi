<?php

require_once __DIR__ . '/../vendor/autoload.php';

$connection = new \JiriSmach\FaynSmsApi\Connection('username', 'password');

$smsWrapper = new \JiriSmach\FaynSmsApi\Wrappers\SmsWrapper();
$smsWrapper->setNumber('777777777');
$smsWrapper->setText('Test text');

$sms = new \JiriSmach\FaynSmsApi\Sms($connection);
$sms->sendSms($smsWrapper);
