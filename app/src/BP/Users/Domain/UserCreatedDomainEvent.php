<?php

namespace App\BP\Users\Domain;

use App\Shared\Application\Bus\Event\Event;
use App\Shared\Domain\Exception\InvalidParametersException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserCreatedDomainEvent extends Event
{
    const NAME = 'user.registered';

    /** @var UuidInterface */
    private $aggregateId;

    public function __construct(UuidInterface $uuid)
    {
        $this->aggregateId = $uuid;
    }

    public function aggregateId(): UuidInterface
    {
        return $this->aggregateId;
    }
    /**
     * {@inheritDoc}
     */
    public function serialize(): array
    {
        return [
            'aggregate_id' => (string) $this->aggregateId()
        ];
    }
    /**
     * {@inheritDoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            $data['email_address']
        );
    }
    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): self
    {
        try {
            return new static(
                $data['aggregate_id'] ? Uuid::fromString($data['aggregate_id']) : null
            );
        } catch (\Throwable $e) {
            throw new InvalidParametersException(implode(', ', $data));
        }
    }
    public function name(): string
    {
        return self::NAME;
    }
}
