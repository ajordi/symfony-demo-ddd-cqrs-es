<?php

namespace App\Shared\Infrastructure\Exception;

final class ConsumerStoppedBySignalException extends InfrastructureException
{
    /** @var string  */
    protected $message = 'Consumer stopped by system signal';
}
