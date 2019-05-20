<?php

namespace App\Shared\Application\Exception;

final class EventClassNotFoundException extends ApplicationException
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf("Event not found in messages mapping using key: %s", $key));
    }
}
