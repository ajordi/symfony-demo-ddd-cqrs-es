<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSSLConnection;

abstract class BaseAMQP
{
    /** @var AMQPSSLConnection */
    protected $connection;

    /** @var AMQPChannel  */
    protected $channel;

    public function __construct(ConnectionFactory $connection, AMQPChannel $channel = null)
    {
        $connection = $connection->connection();
        $this->connection = $connection;
        $this->channel = $channel;
        if ($connection->connectOnConstruct() &&
            (empty($this->channel) || null === $this->channel->getChannelId())
        ) {
            $this->channel = $this->connection->channel();
        }
    }
}
