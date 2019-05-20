<?php

namespace App\Shared\Domain\Service;

use App\Shared\Application\Bus\Event\Event;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

trait EventSourceAggregateRoot
{
    /** @var DomainMessage[] */
    private $uncommittedEvents = [];

    /** @var int */
    private $playhead          = -1; // 0-based playhead allows events[0] to contain playhead 0

    public function getUncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream($this->uncommittedEvents);
        $this->uncommittedEvents = [];

        return $stream;
    }

    public function addEvent(Event $event)
    {
        $this->playhead++;
        $this->uncommittedEvents[] = DomainMessage::recordNow(
            $this->getAggregateRootId(),
            $this->playhead,
            new Metadata([]),
            $event
        );
    }
}
