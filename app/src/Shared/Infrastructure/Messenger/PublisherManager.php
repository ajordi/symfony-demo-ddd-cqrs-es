<?php

namespace App\Shared\Infrastructure\Messenger;

use PhpAmqpLib\Message\AMQPMessage;

interface PublisherManager
{
    public function publish(AMQPMessage $message, string $exchange, string $routingKey);
}
