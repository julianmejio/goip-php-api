<?php

namespace GoIP\Sms;

use GoIP\Sms;

class SmsAdapter
{
    /**
     * @var Sms
     */
    private $client;

    public function __construct(Sms $client)
    {
        $this->client  = $client;
    }

    public function findAll(): array
    {
        return $this->client->getMessages();
    }
}
