<?php

namespace App\Shared\Application\Bus\Event;

use App\Shared\Domain\Messenger\Message;
use Broadway\Serializer\Serializable;

abstract class Event implements Serializable, Message
{
}
