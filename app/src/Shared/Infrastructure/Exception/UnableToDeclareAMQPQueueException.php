<?php

namespace App\Shared\Infrastructure\Exception;

final class UnableToDeclareAMQPQueueException extends InfrastructureException
{
    public function __construct(string $message)
    {
        $message = sprintf('Unable to declare AMQP queue: %s', $message);

        parent::__construct($message);
    }
}
