<?php

require_once(__DIR__ . '/bootstrap.php');

$server = new \GoIP\RemoteControl\Server(
    $_ENV['REMOTE_CONTROL_ADDRESS'],
    intval($_ENV['REMOTE_CONTROL_PORT']),
    $_ENV['REMOTE_CONTROL_USERNAME'],
    $_ENV['REMOTE_CONTROL_PASSWORD']
);

// Get the list of slaves connected to the remote control server.
/** @var \GoIP\RemoteControl\Slave[] $slaves */
$slaves = $server->findSlaves();
dump($slaves);

// Get a slave sing findSlaveByName method
$slave = $server->findSlaveByName($_ENV['SLAVE_NAME']);
dump($slave);

// Let's do an elaborated SMS query

// Create a client for the default slave
$slaveClient = $slave->createClient($_ENV['GOIP_CLIENT_USERNAME'], $_ENV['GOIP_CLIENT_PASSWORD']);
// Create a base SMS with the client
$slaveSms = new \GoIP\Sms($slaveClient);
// Create an adapter
$smsAdapter = new \GoIP\Sms\SmsAdapter($slaveSms);
// Create a SMS mapper
$mapper = new \GoIP\Sms\SmsMapper($smsAdapter);
// Get all the SMS
$messages = $mapper->findAll();
// And dump it
dump($messages);
