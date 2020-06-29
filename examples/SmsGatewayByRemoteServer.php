<?php

require_once(__DIR__ . '/bootstrap.php');

// Define the server
$server = new \GoIP\RemoteControl\Server(
    $_ENV['REMOTE_CONTROL_ADDRESS'],
    \GoIP\RemoteControl\Server::DEFAULT_WEB_PORT,
    $_ENV['REMOTE_CONTROL_USERNAME'],
    $_ENV['REMOTE_CONTROL_PASSWORD']
);

// Get the default slave
$slave = $server->findSlave($_ENV['SLAVE_NAME']);

// Create the SMS gateway
$slaveGateway = $slave->getSmsGateway(
    $_ENV['GOIP_CLIENT_USERNAME'],
    $_ENV['GOIP_CLIENT_PASSWORD']
)
    // And set the timeout configuration
    ->setConnectTimeout(intval($_ENV['CONNECT_TIMEOUT']))
    ->setTimeout(intval($_ENV['TIMEOUT']))
;

// Make a ping request
$sms = $slaveGateway->sendSmsAndWaitResponse(
    $_ENV['TEST_ADDRESSEE'],
    $_ENV['TEST_MESSAGE'],
    intval($_ENV['GOIP_CLIENT_DEFAULT_LINE']),
    intval($_ENV['TIMEOUT'])
);

// And dump it
dump($sms);
