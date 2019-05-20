<?php

namespace App\Shared\Infrastructure\Messenger\AMQP;

use App\Shared\Infrastructure\Exception\UnrecoverableException;
use Psr\Log\LoggerInterface;

class MessageHandlingLogger
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logMessageDispatched(string $routingKey, string $messageBody)
    {
        $message = sprintf(
            'Message with routing key %s and body %s has been dispatched successfully',
            $routingKey,
            $messageBody
        );

        $this->logger->info($message);
    }

    public function logProcessingMessage(string $messageProcessor, string $messageBody)
    {
        $message = sprintf(
            'Processing message body %s with %s',
            $messageBody,
            $messageProcessor
        );

        $this->logger->info($message);
    }

    public function logRequeueException(\Throwable $exception, string $messageProcessor, string $messageBody)
    {
        $message = sprintf(
            'Uncaught %s Processor Exception %s: "%s" at %s line %s using message: %s',
            $messageProcessor,
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $messageBody
        );

        $this->logException($exception, $messageBody, $message);
    }

    public function logDiscardedException(\Throwable $exception, string $messageProcessor, string $messageBody)
    {
        $message = sprintf(
            'Discarding message for uncaught %s Processor Exception %s: "%s" at %s line %s using message: %s',
            $messageProcessor,
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $messageBody
        );

        $this->logException($exception, $messageBody, $message);
    }

    private function logException(\Throwable $exception, string $messageBody, string $message)
    {
        if ($exception instanceof UnrecoverableException) {
            $this->logger->error($message, ['message' => $messageBody, 'exception' => $exception]);
        } else {
            $this->logger->critical($message);
        }
    }
}
