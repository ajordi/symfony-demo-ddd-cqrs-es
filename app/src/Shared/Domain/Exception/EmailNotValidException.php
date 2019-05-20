<?php

namespace App\Shared\Domain\Exception;

final class EmailNotValidException extends DomainException
{
    /** @var string  */
    protected $message = 'Email validation failed.';
}
