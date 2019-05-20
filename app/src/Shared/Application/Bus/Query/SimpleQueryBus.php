<?php

namespace App\Shared\Application\Bus\Query;

use App\Shared\Application\Exception\Bus\Query\QueryHandlerNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SimpleQueryBus implements QueryBus
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function ask(Query $query)
    {
        $handlerClass = \get_class($query) . 'Handler';
        /** @var QueryHandler $handler */
        if ($handler = $this->container->get($handlerClass)) {
            return $handler->handle($query);
        }

        throw new QueryHandlerNotFoundException($handlerClass);
    }
}
