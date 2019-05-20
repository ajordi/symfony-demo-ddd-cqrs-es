<?php

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Infrastructure\Exception\QueueConfigurationNotFound;

class QueueConfigResolver
{
    /** @var array */
    private $exchanges;

    public function __construct(array $exchanges)
    {
        $this->exchanges = $exchanges;
    }

    /**
     * @throws QueueConfigurationNotFound
     */
    public function config(string $queueName): array
    {
        foreach ($this->exchanges as $exchange) {
            if (isset($exchange['queues'][$queueName]) && isset($exchange['queues'][$queueName]['queue_properties'])) {
                return $exchange['queues'][$queueName];
            }
        }
        throw new QueueConfigurationNotFound($queueName);
    }
}
