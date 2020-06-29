<?php

// -->
/**
 * GoIP Client/Server Package based on
 * GoIP SMS Gateway Interface.
 *
 * (c) 2017 April Sacil
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace GoIP;

/**
 * Base Class
 *
 * @package  GoIP
 *
 * @author   April Sacil <aprilvsacil@gmail.com>
 * @standard PSR-2
 */
class Base
{
    const DEFAULT_CONNECT_TIMEOUT = 5000;
    const DEFAULT_TIMEOUT = 60000;

    /**
     * @var int
     */
    private $connectTimeout;

    /**
     * @var int
     */
    private $timeout;

    public $goip;

    /**
     * Initialize the client connection
     * given the host, port, username and password
     *
     */
    public function __construct(
        GoipClient $goip,
        int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        int $timeout = self::DEFAULT_TIMEOUT
    ) {
        $this->goip = $goip;
        $this->connectTimeout = $connectTimeout;
        $this->timeout = $timeout;
    }

    /**
     * Does a curl in the GoIP GSM Modem
     *
     * @param string $route
     *
     * @return resource
     */
    public function connect($route, array $params = [], array $data = [])
    {
        $url  = "http://" . $this->goip->host . '/default/en_US';
        $url .= $route . '?' . http_build_query($params);
        $user = $this->goip->username . ":" . $this->goip->password;
        $curl = curl_init($url);

        curl_setopt_array(
            $curl,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERPWD => $user,
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_PORT => $this->goip->port,
                CURLOPT_CONNECTTIMEOUT_MS => $this->connectTimeout,
                CURLOPT_TIMEOUT_MS => $this->timeout,
            ]
        );

        if ($data) {
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($data),
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            ]);
        }

        $results = curl_exec($curl);
        curl_close($curl);
        
        return $results;
    }

    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    public function setConnectTimeout(int $connectTimeout): Base
    {
        $this->connectTimeout = $connectTimeout;
        return $this;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setTimeout(int $timeout): Base
    {
        $this->timeout = $timeout;
        return $this;
    }
}
