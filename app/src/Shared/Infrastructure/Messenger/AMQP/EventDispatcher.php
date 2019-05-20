<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;

class EventDispatcher implements EventListener
{
    const AMQP_EVENT_EXCHANGE = 'acme-event';
    /** @var MessagePublisher */
    private $publisher;
    /** @var MessageHandlingLogger */
    private $messageHandlingLogger;
    public function __construct(MessagePublisher $publisher, MessageHandlingLogger $messageHandlingLogger)
    {
        $this->publisher = $publisher;
        $this->messageHandlingLogger = $messageHandlingLogger;
    }
    /**
     * @throws UnableToPublishAMQPMessageException
     */
    public function handle(DomainMessage $domainMessage): void
    {
        /** @var Event $event */
        $event = $domainMessage->getPayload();
        $serializedPayload = $event->serialize();
        $serializedMetadata = $domainMessage->getMetadata()->serialize();
        $serializedMetadata['occurred_on'] = $domainMessage->getRecordedOn()->toString();
        $messageName = $event->name();
        $messageBody = json_encode(
            [
                'name' => $messageName,
                'payload' => $serializedPayload,
                'metadata' => $serializedMetadata,
            ]
        );
        $message = new Message($messageBody);
        try {
            $this->publisher->publish($message, self::AMQP_EVENT_EXCHANGE, $messageName);
            $this->messageHandlingLogger->logMessageDispatched($messageName, $messageBody);
        } catch (\Throwable $e) {
//            throw new UnableToPublishAMQPMessageException($e->getMessage());
        }
    }
}
