<?php

namespace GoIP\RemoteControl;

use GoIP\GoipClient;
use GoIP\Sms;
use GoIP\Sms\SmsGateway;

/**
 * A GoIP device connected to a remote control server.
 *
 * @package GoIP\RemoteControl
 */
class Slave
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $exposedIpAddress;

    /**
     * Creates a {@link Slave} from its state.
     *
     * @param \SimpleXMLElement $state State retrieved from the server response.
     *
     * @return Slave Returns the slave object.
     */
    public static function fromState(\SimpleXMLElement $state): Slave
    {
        if (!preg_match('#https?://([^:]+):(\d+)#', (string) $state->td[2]->a['href'], $urlMatches)) {
            throw new \RuntimeException('Bad slave URL');
        }
        return (new self())
            ->setName(trim((string) $state->td[0]))
            ->setExposedIpAddress(trim((string) $state->td[1]))
            ->setPort($urlMatches[2]);
    }

    /**
     * Creates a new {@link GoipClient} linking to the current slave.
     *
     * @param string $username GoIP username.
     * @param string $password GoIP password.
     *
     * @return GoipClient Returns the client for the slave.
     */
    public function createClient(string $username = '', string $password = ''): GoipClient
    {
        return new GoipClient(
            $this->server->getAddress(),
            $username,
            $password,
            $this->port
        );
    }

    /**
     * Creates an SMS gateway for sending and receiving SMS.
     *
     * @param string $username GoIP Username.
     * @param string $password GoIP password.
     *
     * @return SmsGateway Returns the created SMS gateway.
     */
    public function getSmsGateway(string $username = '', string $password = ''): SmsGateway
    {
        return new SmsGateway(new Sms($this->createClient($username, $password)));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Slave
    {
        $this->name = $name;
        return $this;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): Slave
    {
        $this->server = $server;
        return $this;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): Slave
    {
        $this->port = $port;
        return $this;
    }

    public function getExposedIpAddress(): string
    {
        return $this->exposedIpAddress;
    }

    public function setExposedIpAddress(string $exposedIpAddress): Slave
    {
        $this->exposedIpAddress = $exposedIpAddress;
        return $this;
    }
}
