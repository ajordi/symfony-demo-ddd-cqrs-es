<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Domain\Exception\InvalidParametersException;
use App\Shared\Domain\Messenger\Metadata;
use PhpAmqpLib\Message\AMQPMessage;

class MetadataDecoder
{
    /**
     * @throws InvalidParametersException
     */
    public function build(AMQPMessage $AMQPMessage): Metadata
    {
        $messageBody = json_decode($AMQPMessage->getBody(), true);
        $messageMetadata = $messageBody['metadata'] ?? [];
        try {
            return new Metadata($messageMetadata);
        } catch (\Throwable $e) {
            throw new InvalidParametersException(
                is_array($messageMetadata)
                    ? implode(', ', $messageMetadata)
                    : $messageMetadata
            );
        }
    }
}
