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
$slaves = $server->findSlaves();
dump($slaves);
