<?php

namespace App\Shared\Infrastructure\Exception;

final class UnableToBindAMQPQueueException extends InfrastructureException
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Unable to bind AMQP queue: %s', $message));
    }
}
