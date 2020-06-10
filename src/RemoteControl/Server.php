<?php


namespace GoIP\RemoteControl;

/**
 * Remote administration server v1.08 client.
 *
 * @package GoIP\RemoteControl
 */
class Server
{
    const DEFAULT_WEB_PORT = 8086;

    /**
     * @var string
     */
    private $address;

    /**
     * @var null|int
     */
    private $port;

    /**
     * @var null|string
     */
    private $username;

    /**
     * @var null|string
     */
    private $password;

    public function __construct(string $address, ?int $port = self::DEFAULT_WEB_PORT, ?string $username = null, ?string $password = null)
    {
        $this->address = $address;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get all the slaves that are connected to the remote control server.
     *
     * @return array Returns an array with the slaves registered in the server.
     */
    public function findSlaves(): array
    {
        return $this->getSlaveStates($this->requestPage());
    }

    /**
     * Transforms the states of the slaves into {@link Slave}.
     *
     * @return array Returns the list of slave objects accordingly to the server.
     */
    private function getSlaveStates(string $serverResponse): array
    {
        $states = [];
        $responseReader = new \SimpleXMLElement($serverResponse);
        $slavesRows = $responseReader->xpath('/html/body/center/table/tr');
        foreach ($slavesRows as $row) {
            $slave = $this->mapStateToSlave($row);
            $states[$slave->getName()] = $slave;
        }
        return $states;
    }

    /**
     * Transforms one {@link \SimpleXMLElement} state into {@link Slave}.
     *
     * @param \SimpleXMLElement $state State to transform.
     *
     * @return Slave Returns the Slave accordingly to the state.
     */
    private function mapStateToSlave(\SimpleXMLElement $state): Slave
    {
        return Slave::fromState($state);
    }

    /**
     * Request a HTTP page against the remote control server web interface.
     *
     * @param string|null $page       Page to request. Blank means the main page.
     * @param array       $parameters Query portion of the URL.
     * @param array       $data       POST data.
     *
     * @return string Returns the contents of the requested page.
     */
    private function requestPage(?string $page = '', array $parameters = [], array $data = []): string
    {
        $url = sprintf('http://%s:%s/%s', $this->address, $this->port, $page);
        if (0 < count($parameters)) {
            $url .= sprintf('?%s', http_build_query($parameters));
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($this->username)) {
            curl_setopt_array($ch, [
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => sprintf('%s:%s', $this->username, $this->password)
            ]);
        }
        if (0 < count($data)) {
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
                CURLOPT_POST => count($data),
                CURLOPT_POSTFIELDS => http_build_query($data),
            ]);
        }
        $response = curl_exec($ch);
        if (false === $response) {
            throw new \RuntimeException(curl_error($ch), curl_errno($ch));
        }
        // Sanitize the malformed HTML page from the server.
        $responseDom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $responseDom->loadHTML($response);
        libxml_use_internal_errors(false);
        return $responseDom->saveHTML();
    }

    
    public function getAddress(): string
    {
        return $this->address;
    }

    
    public function setAddress(string $address): Server
    {
        $this->address = $address;
        return $this;
    }

    
    public function getPort(): ?int
    {
        return $this->port;
    }

    
    public function setPort(?int $port): Server
    {
        $this->port = $port;
        return $this;
    }

    
    public function getUsername(): ?string
    {
        return $this->username;
    }

    
    public function setUsername(?string $username): Server
    {
        $this->username = $username;
        return $this;
    }

    
    public function setPassword(?string $password): Server
    {
        $this->password = $password;
        return $this;
    }
}
