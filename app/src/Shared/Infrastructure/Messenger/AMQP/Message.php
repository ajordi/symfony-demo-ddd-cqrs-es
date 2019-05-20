<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use PhpAmqpLib\Message\AMQPMessage;

class Message extends AMQPMessage
{
    public function __construct(string $body = '', array $properties = [])
    {
        $properties['content_type'] = isset($properties['content_type'])
            ? $properties['content_type']
            : 'application/json';

        $properties['delivery_mode'] = isset($properties['delivery_mode'])
            ? $properties['delivery_mode']
            : Message::DELIVERY_MODE_PERSISTENT;

        parent::__construct($body, $properties);
    }
}
