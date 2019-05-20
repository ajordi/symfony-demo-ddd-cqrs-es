<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Exception\ConsumerNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConsumerResolver
{
    const CONSUMER_DEFAULT_BINDING = 'consumer_';

    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ConsumerNotFoundException
     */
    public function resolve(string $consumerName): MessageHandler
    {
        return $this->container->get(self::CONSUMER_DEFAULT_BINDING . $consumerName);
    }
}
