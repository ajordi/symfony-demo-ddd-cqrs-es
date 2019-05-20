<?php

namespace App\Shared\Application\Bus\Event;

interface EventHandler
{
    public function supports(DomainEvent $event): bool;

    public function handle(DomainEvent $event): void;
}
