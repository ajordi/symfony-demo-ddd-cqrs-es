<?php

namespace App\Shared\Application\Bus\Event;

use App\BP\Users\Domain\UserCreatedDomainEvent;
use App\Shared\Application\Exception\EventClassNotFoundException;

class EventMessageMapper
{
    private static $mapping = [
        UserCreatedDomainEvent::NAME => UserCreatedDomainEvent::class,
    ];

    /**
     * @throws EventClassNotFoundException
     */
    public static function resolveMessage(string $key): string
    {
        if (!array_key_exists($key, self::$mapping) || !class_exists(self::$mapping[$key])) {
            throw new EventClassNotFoundException($key);
        }

        return self::$mapping[$key];
    }
}
