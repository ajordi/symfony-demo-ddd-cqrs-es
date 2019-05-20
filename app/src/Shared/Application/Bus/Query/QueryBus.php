<?php

namespace App\Shared\Application\Bus\Query;

interface QueryBus
{
    /**
     * @param Query $query
     * @return mixed
     * @throws \App\Shared\Application\Exception\Bus\Query\QueryHandlerNotFoundException
     */
    public function ask(Query $query);
}
