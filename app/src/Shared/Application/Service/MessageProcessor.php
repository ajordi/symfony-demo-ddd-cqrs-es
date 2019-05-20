<?php

namespace App\Shared\Application\Service;

use App\Shared\Domain\Messenger\Message;
use App\Shared\Domain\Messenger\Metadata;

interface MessageProcessor
{
    public function process(Message $message, Metadata $metadata);
}
