<?php

namespace App\Shared\Infrastructure\Ui\Cli;

use App\Shared\Infrastructure\Messenger\AMQP\ConnectionFactory;
use PhpAmqpLib\Channel\AMQPChannel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupQueueFromExchange extends Command
{
    /** @var AMQPChannel */
    private $amqpChannel;

    /** @var  array */
    private $exchanges;

    public function __construct(ConnectionFactory $connection, array $exchanges)
    {
        parent::__construct(null);
        $this->amqpChannel = $connection->connection()->channel();
        $this->exchanges = $exchanges;
    }

    protected function configure()
    {
        $this
            ->setName('queue:setup')
            ->setDescription('Create queues based on their routing keys in the amqp config file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->exchanges as $exchange => $config) {
            $exchangeProperties = $config['properties'];
            $this->amqpChannel->exchange_declare(
                $exchange,
                $exchangeProperties['exchange_type'] ?? null,
                $exchangeProperties['exchange_passive'] ?? false,
                $exchangeProperties['exchange_durable'] ?? false,
                $exchangeProperties['exchange_auto_delete'] ?? true,
                $exchangeProperties['exchange_internal'] ?? false,
                $exchangeProperties['exchange_nowait'] ?? true,
                $exchangeProperties['exchange_arguments'] ?? null,
                $exchangeProperties['exchange_ticket'] ?? null
            );
            foreach ($config['queues'] as $queueName => $queue) {
                $queueProperties = $queue['queue_properties'] ?? null;
                $this->amqpChannel->queue_declare(
                    $queueName,
                    $queueProperties['queue_passive'] ?? false,
                    $queueProperties['queue_durable'] ?? false,
                    $queueProperties['queue_exclusive'] ?? false,
                    $queueProperties['queue_autodelete'] ?? true,
                    $queueProperties['queue_nowait'] ?? true,
                    $queueProperties['queue_properties'] ?? null,
                    $queueProperties['queue_ticket'] ?? null
                );
                $this->amqpChannel->queue_bind(
                    $queueName,
                    $exchange,
                    $queue['routing_key'],
                    $queue['no_wait'] ?? false
                );
            }
        }
    }
}
