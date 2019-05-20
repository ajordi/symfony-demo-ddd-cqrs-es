<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Application\Service\MessageProcessor;
use App\Shared\Domain\Messenger\AMQPMessageDecoder;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class MessageHandler
{
    /** @var MessageProcessor */
    private $messageProcessor;

    /** @var AMQPMessageDecoder */
    private $AMQPMessageDecoder;

    /** @var MetadataDecoder */
    private $AMQPMetadataDecoder;

    public function __construct(
        MessageProcessor $messageProcessor,
        AMQPMessageDecoder $AMQPMessageDecoder,
        MetadataDecoder $AMQPMetadataDecoder
    ) {
        $this->messageProcessor = $messageProcessor;
        $this->AMQPMessageDecoder = $AMQPMessageDecoder;
        $this->AMQPMetadataDecoder = $AMQPMetadataDecoder;
    }
    public function handle(AMQPMessage $AMQPMessage, AMQPChannel $channel)
    {

        try {
            $message = $this->AMQPMessageDecoder->build($AMQPMessage);
            $metadata = $this->AMQPMetadataDecoder->build($AMQPMessage);

            $this->messageProcessor->process($message, $metadata);
            $channel->basic_ack($AMQPMessage->delivery_info['delivery_tag']);
        } catch (\Throwable $throwable) {
            $this->retryFailedMessage($AMQPMessage, $channel, $throwable);
        }
    }
    private function retryFailedMessage(AMQPMessage $AMQPMessage, AMQPChannel $resolver, \Throwable $exception)
    {
        $messageProcessor = \get_class($this->messageProcessor);
        $resolver->basic_reject($AMQPMessage->delivery_info['delivery_tag'], false);
    }
}
