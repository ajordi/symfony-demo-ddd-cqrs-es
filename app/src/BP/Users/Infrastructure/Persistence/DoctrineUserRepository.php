<?php

namespace App\BP\Users\Infrastructure\Persistence;

use App\BP\Users\Domain\EmailAddress;
use App\BP\Users\Domain\User;
use App\BP\Users\Domain\UserRepository;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    /**
     * @inheritdoc
     */
    public function save(User $user): void
    {
        $this->saveAndEmitEvents($user);
    }

    /**
     * @inheritdoc
     */
    public function ofEmailAddress(EmailAddress $emailAddress): ? User
    {
        /** @var User $route */
        $user = $this->repository(User::class)->findOneBy([
            'emailAddress' => (string) $emailAddress
        ]);

        return $user;
    }
}
