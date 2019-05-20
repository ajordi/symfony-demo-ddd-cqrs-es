<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Application\Bus\Event\Event;
use App\Shared\Application\Bus\Event\EventMessageMapper;
use App\Shared\Domain\Messenger\AMQPMessageDecoder;
use PhpAmqpLib\Message\AMQPMessage;

class EventDecoder implements AMQPMessageDecoder
{
    public function build(AMQPMessage $AMQPMessage): Event
    {
        $messageBody = json_decode($AMQPMessage->getBody(), true);
        $messagePayload = $messageBody['payload'] ?? [];
        $routingKey = $messageBody['name'] ?? null;

        $event = EventMessageMapper::resolveMessage($routingKey);

        return $event::fromArray($messagePayload);
    }
}
