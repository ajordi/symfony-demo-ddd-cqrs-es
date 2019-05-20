<?php

namespace App\Shared\Domain\Messenger;

use PhpAmqpLib\Message\AMQPMessage;

interface AMQPMessageDecoder
{
    /**
     * @return Message
     */
    public function build(AMQPMessage $AMQPMessage);
}
