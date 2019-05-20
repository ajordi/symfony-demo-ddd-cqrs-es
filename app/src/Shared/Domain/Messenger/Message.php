<?php

namespace App\Shared\Domain\Messenger;

interface Message
{
    public function serialize(): array;
}
