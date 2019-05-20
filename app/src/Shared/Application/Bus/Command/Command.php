<?php

namespace App\Shared\Application\Bus\Command;

interface Command
{
    public static function fromArray(array $data): self;
}
