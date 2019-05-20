<?php

namespace App\BP\Users\Application\Notify;

use App\Shared\Application\Bus\Command\Command;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class NotifyEmailValidationCommand implements Command
{
    /** @var UuidInterface */
    private $uuid;

    public static function fromArray(array $data): Command
    {
        return new self(
            Uuid::fromString($data['uuid'])
        );
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }
}
