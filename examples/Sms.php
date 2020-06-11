<?php

require_once(__DIR__ . '/bootstrap.php');

$goip = new \GoIP\GoipClient(
    $_ENV['GOIP_CLIENT_ADDRESS'],
    $_ENV['GOIP_CLIENT_USERNAME'],
    $_ENV['GOIP_CLIENT_PASSWORD'],
    intval($_ENV['GOIP_CLIENT_PORT'])
);

// Declare the client and get the messages
$sms = new \GoIP\Sms($goip);
$messages = $sms->getMessages();

// Dump all the messages
dump($messages);

// Get the messages of the default line
$lineMessages = $sms->getLineMessages(intval($_ENV['GOIP_CLIENT_DEFAULT_LINE']));
dump($lineMessages);

// Send a message
// Uncomment these lines if you want to test the sending feature.
//$result = $sms->sendSms(2, '09158786696', 'Yey!');
//dump($result);
