<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Exception\UnableToDeclareAMQPQueueException;
use App\Shared\Infrastructure\Messenger\QueueConfigResolver;
use PhpAmqpLib\Channel\AMQPChannel;

class QueueDeclarer
{
    /** @var  QueueConfigResolver */
    private $queueConfigResolver;

    public function __construct(QueueConfigResolver $queueConfigResolver)
    {
        $this->queueConfigResolver = $queueConfigResolver;
    }

    /**
     * @throws UnableToDeclareAMQPQueueException
     */
    public function declare(string $queueName, AMQPChannel $channel)
    {
        try {
            $queueProperties = $this->queueConfigResolver->config($queueName);

            $channel->queue_declare(
                $queueName,
                $queueProperties['queue_properties']['queue_passive'] ?? false,
                $queueProperties['queue_properties']['queue_durable'] ?? false,
                $queueProperties['queue_properties']['queue_exclusive'] ?? false,
                $queueProperties['queue_properties']['queue_autodelete'] ?? true,
                $queueProperties['queue_properties']['queue_nowait'] ?? true,
                $queueProperties['queue_properties']['queue_properties'] ?? null,
                $queueProperties['queue_properties']['queue_ticket'] ?? null
            );
        } catch (\Throwable $e) {
            throw new UnableToDeclareAMQPQueueException($e->getMessage());
        }
    }
}
