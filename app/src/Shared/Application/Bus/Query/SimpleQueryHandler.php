<?php

namespace App\Shared\Application\Bus\Query;

/**
 * Convenience base class for query handlers.
 *
 * Query handlers using this base class will implement `handle<QueryName>`
 * methods for each query they can handle.
 *
 * Note: the convention used does not take namespaces into account.
 */
abstract class SimpleQueryHandler implements QueryHandler
{
    /**
     * {@inheritDoc}
     */
    public function handle(Query $query)
    {
        $method = $this->getHandleMethod($query);

        if (! method_exists($this, $method)) {
            return;
        }

        return $this->$method($query);
    }

    private function getHandleMethod(Query $query)
    {
        $classParts = explode('\\', get_class($query));

        return 'handle' . end($classParts);
    }
}
