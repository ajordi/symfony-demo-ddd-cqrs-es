<?php

namespace App\Shared\Infrastructure\Ui\Cli;

use App\Shared\Infrastructure\Exception\ConsumerStoppedBySignalException;
use App\Shared\Infrastructure\Messenger\ConsumerManager;
use App\Shared\Infrastructure\Messenger\QueueConfigResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartConsumerCommand extends Command
{
    /** @var ConsumerManager */
    private $consumerManager;

    /** @var  QueueConfigResolver */
    private $queueConfigResolver;

    public function __construct(ConsumerManager $consumerStarter, QueueConfigResolver $queueConfigResolver)
    {
        parent::__construct(null);

        $this->consumerManager = $consumerStarter;
        $this->queueConfigResolver = $queueConfigResolver;
    }

    protected function configure()
    {
        $this
            ->setName('consumer:start')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the consumer')
            ->setDescription('Start the specified consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = $input->getArgument('name');
        $config = $this->queueConfigResolver->config($consumer);

        $this->consumerManager->start($consumer, $config['routing_key'], 0);
    }

    /**
     * @throws ConsumerStoppedBySignalException
     */
    public function stopConsumer()
    {
        pcntl_signal_dispatch();
        echo(sprintf("\nTrying to stop consumer gracefully.....\n\n"));
        $this->consumerManager->stop();

        throw new ConsumerStoppedBySignalException();
    }

    private function manageSystemSignals()
    {
        pcntl_signal(SIGTERM, array(&$this, 'stopConsumer'));
        pcntl_signal(SIGINT, array(&$this, 'stopConsumer'));
    }
}
