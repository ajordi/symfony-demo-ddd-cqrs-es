<?php

namespace App\Shared\Domain\Exception;

use Throwable;

final class InvalidParametersException extends DomainException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Parameters are not valid, got: %s', $message), $code, $previous);
    }
}
