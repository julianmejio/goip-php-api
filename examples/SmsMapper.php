<?php

require_once(__DIR__ . '/bootstrap.php');

/*
 * Why work with mappers?
 *
 * This mapper is one-way only… for now. The main goal of it is to provide a
 * consistent in-memory data structure to work with. It also allows to work with
 * expected data types, and the structure itself is entity-able.
 *
 * In this example you will:
 *
 * 1. Create a GoIPClient.
 * 2. Link the SMS API to the GoIPClient
 * 3. Create an adapter and link it to the SMS API.
 * 4. Create a SMS mapper, and link it to the previous created adapter.
 * 5. Find the messages from all the lines.
 */

$client = new \GoIP\GoipClient(
    $_ENV['GOIP_CLIENT_ADDRESS'],
    $_ENV['GOIP_CLIENT_USERNAME'],
    $_ENV['GOIP_CLIENT_PASSWORD'],
    intval($_ENV['GOIP_CLIENT_PORT'])
);
$smsApi = new \GoIP\Sms($client);
$adapter = new \GoIP\Sms\SmsAdapter($smsApi);
$mapper = new \GoIP\Sms\SmsMapper($adapter);
$messages = $mapper->findAll();
dump($messages);
