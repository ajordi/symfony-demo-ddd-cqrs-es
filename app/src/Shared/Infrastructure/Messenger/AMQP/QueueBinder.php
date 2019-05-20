<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Exception\UnableToBindAMQPQueueException;
use PhpAmqpLib\Channel\AMQPChannel;

class QueueBinder
{
    /** @var string */
    private $exchange;
    /** @var int */
    private $prefetchSize;
    /** @var int */
    private $prefetchCount;
    /** @var bool */
    private $isGlobal;
    public function __construct(string $exchange, int $prefetchSize, int $prefetchCount, bool $isGlobal)
    {
        $this->exchange = $exchange;
        $this->prefetchSize = $prefetchSize;
        $this->prefetchCount = $prefetchCount;
        $this->isGlobal = $isGlobal;
    }
    /**
     * @throws UnableToBindAMQPQueueException
     */
    public function bind(string $queueName, string $routingKey, AMQPChannel $channel)
    {
        try {
            $channel->queue_bind($queueName, $this->exchange, $routingKey);
            $channel->basic_qos($this->prefetchSize, $this->prefetchCount, $this->isGlobal);
        } catch (\Throwable $e) {
            throw new UnableToBindAMQPQueueException($e->getMessage());
        }
    }
}
