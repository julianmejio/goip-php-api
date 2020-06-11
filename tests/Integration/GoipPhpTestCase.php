<?php

namespace Tests\GoIP\Integration;

use GoIP\GoipClient;
use GoIP\RemoteControl\Server;
use GoIP\Sms;
use PHPUnit\Framework\TestCase;

class GoipPhpTestCase extends TestCase
{
    /**
     * @var GoipClient
     */
    public static $goipClient;

    /**
     * @var Sms
     */
    public static $sms;

    /**
     * @var Sms\SmsAdapter
     */
    public static $smsAdapter;

    /**
     * @var Sms\SmsMapper
     */
    public static $smsMapper;

    /**
     * @var Server
     */
    public static $server;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$server = new Server(
            $_ENV['REMOTE_CONTROL_ADDRESS'],
            intval($_ENV['REMOTE_CONTROL_PORT']),
            $_ENV['REMOTE_CONTROL_USERNAME'],
            $_ENV['REMOTE_CONTROL_PASSWORD']
        );
        self::$goipClient = new GoipClient(
            $_ENV['GOIP_CLIENT_ADDRESS'],
            $_ENV['GOIP_CLIENT_USERNAME'],
            $_ENV['GOIP_CLIENT_PASSWORD'],
            intval($_ENV['GOIP_CLIENT_PORT'])
        );
        self::$sms = new Sms(self::$goipClient);
        self::$smsAdapter = new Sms\SmsAdapter(self::$sms);
        self::$smsMapper = new Sms\SmsMapper(self::$smsAdapter);
    }
}
