<?php

namespace App\BP\Users\Domain;

use App\Shared\Domain\Service\EventSourceAggregateRoot;
use Broadway\Domain\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class User implements AggregateRoot
{
    use EventSourceAggregateRoot;

    /** @var int|null */
    private $id;

    /** @var UuidInterface */
    private $uuid;

    /** @var string */
    private $emailAddress;

    public static function create(UuidInterface $uuid, EmailAddress $emailAddress): self
    {
        $user = new self($uuid, $emailAddress);
        $user->addEvent(new UserCreatedDomainEvent($uuid));

        return $user;
    }

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->uuid;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function emailAddress(): string
    {
        return $this->emailAddress;
    }

    private function __construct(UuidInterface $uuid, string $emailAddress)
    {
        $this->uuid = $uuid;
        $this->emailAddress = $emailAddress;
    }
}
