<?php

namespace App\Shared\Domain\Messenger;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\ParameterBag;

class Metadata extends ParameterBag
{
    /**
     * @return null | int
     */
    public function authorId()
    {
        return $this->get('author_id');
    }
    /**
     * @return null | DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->get('occurred_on') ?
            DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $this->get('occurred_on')) :
            null;
    }
}
