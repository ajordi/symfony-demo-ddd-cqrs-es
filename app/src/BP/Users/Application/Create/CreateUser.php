<?php

namespace App\BP\Users\Application\Create;

use App\BP\Users\Domain\EmailAddress;
use App\Shared\Application\Bus\Command\Command;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreateUser implements Command
{
    /** @var UuidInterface */
    private $uuid;

    /** @var EmailAddress */
    private $emailAddress;

    /**
     * @param array $data
     * @return Command
     * @throws \App\Shared\Domain\Exception\EmailNotValidException
     */
    public static function fromArray(array $data): Command
    {
        return new self(
            Uuid::fromString($data['uuid']),
            new EmailAddress($data['email_address'])
        );
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    private function __construct(UuidInterface $uuid, EmailAddress $emailAddress)
    {
        $this->uuid = $uuid;
        $this->emailAddress = $emailAddress;
    }
}
