<?php

namespace App\Shared\Infrastructure\Exception;

use Exception;

class InfrastructureException extends Exception
{
    /** @var string  */
    protected $message = 'General Infrastructure Exception';
}
