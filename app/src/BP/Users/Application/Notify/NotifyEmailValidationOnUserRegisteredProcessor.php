<?php

namespace App\BP\Users\Application\Notify;

use App\BP\Users\Domain\UserCreatedDomainEvent;
use App\Shared\Application\Exception\UnrecoverableException;
use App\Shared\Application\Service\MessageProcessor;
use App\Shared\Domain\Exception\EntityNotFound;
use App\Shared\Domain\Exception\InvalidParametersException;
use App\Shared\Domain\Messenger\Message;
use App\Shared\Domain\Messenger\Metadata;
use Broadway\CommandHandling\CommandBus;

class NotifyEmailValidationOnUserRegisteredProcessor implements MessageProcessor
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Message|UserCreatedDomainEvent $message
     * @param Metadata $metadata
     * @throws UnrecoverableException
     */
    public function process(Message $message, Metadata $metadata)
    {
        try {
            /** @uses NotifyEmailValidationCommandHandler::handleNotifyEmailValidationCommand() */
            $this->commandBus->dispatch(
                NotifyEmailValidationCommand::fromArray([
                    'uuid' => (string) $message->aggregateId(),
                ])
            );
        } catch (EntityNotFound $e) {
            throw new UnrecoverableException($e->getMessage());
        } catch (InvalidParametersException $e) {
            throw new UnrecoverableException($e->getMessage());
        }
    }
}
