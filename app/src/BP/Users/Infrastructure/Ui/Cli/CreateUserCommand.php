<?php

namespace App\BP\Users\Infrastructure\Ui\Cli;

use App\BP\Users\Application\Create\CreateUser;
use App\BP\Users\Application\Create\CreateUserHandler;
use Broadway\CommandHandling\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a user')
            ->addArgument('email', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @uses CreateUserHandler::handleCreateUser() */
        $this->commandBus->dispatch(CreateUser::fromArray([
            'uuid' => (string) Uuid::uuid4(),
            'email_address' => $input->getArgument('email')
        ]));
    }
}
