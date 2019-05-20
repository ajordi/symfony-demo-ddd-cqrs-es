<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Exception\UndefinedAMQPChannelException;
use App\Shared\Infrastructure\Messenger\ConsumerManager;
use PhpAmqpLib\Message\AMQPMessage;

class MessageConsumer extends BaseAMQP implements ConsumerManager
{
    const CONSUMER_TAG = 'consumer';

    /** @var QueueBinder */
    private $queueBinder;

    /** @var QueueDeclarer */
    private $queueDeclarer;

    /** @var ConsumerResolver */
    private $consumerResolver;

    public function __construct(
        ConnectionFactory $connection,
        QueueBinder $queueBinder,
        QueueDeclarer $queueDeclarer,
        ConsumerResolver $consumerResolver
    ) {
        $this->connection = $connection->connection();
        $this->queueBinder = $queueBinder;
        $this->queueDeclarer = $queueDeclarer;
        $this->consumerResolver = $consumerResolver;

        parent::__construct($connection);
    }

    public function start(string $consumerName, string $routingKey, int $messagesToBeProcessed = 0)
    {
        $this->queueDeclarer->declare($consumerName, $this->channel);
        $this->queueBinder->bind($consumerName, $routingKey, $this->channel);

        /** @var MessageHandler $messagehandler */
        $messagehandler = $this->consumerResolver->resolve($consumerName);

        $this->channel->basic_consume(
            $consumerName,
            self::CONSUMER_TAG,
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($messagehandler) {
                $messagehandler->handle($message, $this->channel);
            }
        );

        $consumed = 0;

        while (count($this->channel->callbacks)) {
            if ($consumed === $messagesToBeProcessed && $messagesToBeProcessed > 0) {
                $this->stop();
            }

            $this->channel->wait();
            $consumed ++;
        }
    }

    /**
     * @throws UndefinedAMQPChannelException
     */
    public function stop()
    {
        if (!$this->channel) {
            throw new UndefinedAMQPChannelException();
        }

        $this->channel->basic_cancel(self::CONSUMER_TAG, false, true);
    }
}
