<?php

namespace App\BP\Users\Domain;

interface UserRepository
{
    public function save(User $route): void;

    public function ofEmailAddress(EmailAddress $emailAddress): ? User;
}
