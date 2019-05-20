<?php

namespace App\Shared\Application\Bus\Event;

use Ramsey\Uuid\UuidInterface;

abstract class DomainEvent
{
    /** @var UuidInterface */
    public $aggregateId;

    /** @var array */
    public $data;

    public function __construct(UuidInterface $aggregateId, array $data = [])
    {
        $this->aggregateId = $aggregateId;
        $this->data = $data;
    }
}
