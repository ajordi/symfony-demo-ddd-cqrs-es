<?php

namespace App\Shared\Application\Bus\Event;

class EventBus
{
    private $eventHandlers;

    /**
     * @param EventHandler[] $eventHandlers
     */
    public function __construct(iterable $eventHandlers)
    {
        $this->eventHandlers = $eventHandlers;
    }

    public function dispatch(DomainEvent $event)
    {
        foreach ($this->eventHandlers as $handler) {
            /** @var EventHandler $handler */
            if ($handler->supports($event)) {
                $handler->handle($event);
            }
        }
    }
}
