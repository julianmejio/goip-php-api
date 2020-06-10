<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
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

// Get the SMS in inbox from the default line.
$slaveClient = $slave->createClient($_ENV['GOIP_CLIENT_USERNAME'], $_ENV['GOIP_CLIENT_PASSWORD']);
$slaveSms = new \GoIP\Sms($slaveClient);
$messages = $slaveSms->getLineMessages(intval($_ENV['GOIP_CLIENT_DEFAULT_LINE']));
dump($messages);
