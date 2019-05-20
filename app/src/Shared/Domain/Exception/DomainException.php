<?php

namespace App\Shared\Domain\Exception;

use Exception;

class DomainException extends Exception
{
    /** @var string  */
    protected $message = 'General Domain Exception';
}
