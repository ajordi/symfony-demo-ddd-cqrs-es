<?php

namespace App\Shared\Application\Bus\Query;

interface QueryHandler
{
    public function handle(Query $query);
}
