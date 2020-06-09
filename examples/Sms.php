<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$goip = new \GoIP\GoipClient("192.168.0.105", "admin", "admin", 80);

$sms = new \GoIP\Sms($goip);
$messages = $sms->getMessages();
dump($messages);

$lineMessages = $sms->getLineMessages(1);
dump($lineMessages);

$result = $sms->sendSms(2, '09158786696', 'Yey!');
dump($result);
