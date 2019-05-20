<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Messenger\PublisherManager;
use PhpAmqpLib\Message\AMQPMessage;

class MessagePublisher extends BaseAMQP implements PublisherManager
{
    public function publish(AMQPMessage $message, string $exchange, string $routingKey)
    {
        $this->channel->basic_publish($message, $exchange, $routingKey);
    }
}
