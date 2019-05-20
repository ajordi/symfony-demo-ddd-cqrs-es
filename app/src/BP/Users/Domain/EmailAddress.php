<?php

namespace App\BP\Users\Domain;

use App\Shared\Domain\Exception\EmailNotValidException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

class EmailAddress
{
    /** @var string */
    private $email;

    /**
     * EmailAddress constructor.
     * @param string $email
     * @throws EmailNotValidException
     */
    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    /**
     * @throws EmailNotValidException
     */
    private function setEmail(string $email)
    {
        try {
            Validator::email()->check($email);
        } catch (ValidationException $e) {
            throw new EmailNotValidException();
        }

        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email();
    }

    public function equals($object): bool
    {
        return (($object instanceof self) && $object->__toString() === $this->__toString());
    }
}
