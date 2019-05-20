<?php

namespace App\Shared\Infrastructure\Exception;

final class UndefinedAMQPChannelException extends InfrastructureException
{
    /** @var string */
    protected $message = 'AMQP Channel must be defined in order to perform the requested action';
}
