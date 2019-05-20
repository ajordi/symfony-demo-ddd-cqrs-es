<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use PhpAmqpLib\Connection\AMQPSSLConnection;

class ConnectionFactory
{
    /** @var string */
    private $host;

    /** @var string */
    private $port;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $vhost;

    /** @var array */
    private $sslOptions;

    /** @var array */
    private $connectOptions;

    public function __construct(
        string $host,
        string $port,
        string $username,
        string $password,
        string $vhost,
        array $sslOptions,
        array $connectOptions
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->vhost = $vhost;
        $this->sslOptions = $sslOptions;
        $this->connectOptions = $connectOptions;
    }

    public function connection(): AMQPSSLConnection
    {
        return new AMQPSSLConnection(
            $this->host,
            $this->port,
            $this->username,
            $this->password,
            $this->vhost,
            $this->sslOptions,
            $this->connectOptions
        );
    }
}
