<?php

namespace App\Shared\Infrastructure\Messenger;

interface ConsumerManager
{
    public function start(string $consumer, string $routingKey, int $messagesToBeProcessed = 0);

    public function stop();
}
