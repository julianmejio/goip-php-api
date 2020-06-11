<?php

namespace GoIP\Sms;

use GoIP\Sms;

/**
 * Storage adapter compatible with {@link Sms}.
 *
 * @package GoIP\Sms
 */
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

    /**
     * Find all the messages of the client.
     *
     * @return array Return the array-like messages.
     */
    public function findAll(): array
    {
        return $this->client->getMessages();
    }

    /**
     * Find all the messages of a line slot.
     *
     * @param int $line Line slot number.
     *
     * @return array Returns the array-like messages form the line slot.
     */
    public function findByLine(int $line): array
    {
        return $this->client->getLineMessages($line);
    }
}
