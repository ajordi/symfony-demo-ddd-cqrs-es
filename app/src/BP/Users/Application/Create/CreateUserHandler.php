<?php

namespace App\BP\Users\Application\Create;

use App\BP\Users\Domain\User;
use App\BP\Users\Domain\UserRepository;
use Broadway\CommandHandling\SimpleCommandHandler;

class CreateUserHandler extends SimpleCommandHandler
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handleCreateUser(CreateUser $createUser)
    {
        if ($this->userRepository->ofEmailAddress($createUser->emailAddress())) {
            throw new \Exception('User email address exists');
        }

        $this->userRepository->save(User::create(
            $createUser->uuid(),
            $createUser->emailAddress()
        ));
    }
}
