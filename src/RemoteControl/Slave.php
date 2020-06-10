<?php


namespace GoIP\RemoteControl;

use GoIP\GoipClient;

/**
 * A GoIP device connected to a remote control server.
 * Class Slave
 *
 * @package GoIP\RemoteControl
 */
class Slave
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $port;

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
            ->setAddress($urlMatches[1])
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
            $this->address,
            $username,
            $password,
            $this->port
        );
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

    
    public function getAddress(): string
    {
        return $this->address;
    }

    
    public function setAddress(string $address): Slave
    {
        $this->address = $address;
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
}
