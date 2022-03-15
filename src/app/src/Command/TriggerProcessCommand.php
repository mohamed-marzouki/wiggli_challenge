<?php
namespace App\Command;

use App\Event\SendMailEvent;
use App\Strategies\SendMailStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @class TriggerProcessCommand
 */
class TriggerProcessCommand extends Command
{
    protected static $defaultName = 'trigger:process';
    protected static $defaultDescription = 'Trigger Process';
    private ?string $name;
    private EventDispatcherInterface $eventDispatcher;
    private SendMailEvent $sendMailEvent;

    /**
     * @param string|null $name
     * @param SendMailStrategy $sendMail
     */
    public function __construct(string $name = null, EventDispatcherInterface $eventDispatcher, SendMailEvent $sendMailEvent)
    {
        parent::__construct($name);
        $this->name = $name;
        $this->eventDispatcher = $eventDispatcher;
        $this->sendMailEvent = $sendMailEvent;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setHelp('This command allows you to trigger diffrent process that you can find in the Strategy directory')
            ->addArgument('strategy', InputArgument::REQUIRED, 'Strategy to trigger');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        switch ($input->getArgument('strategy')) {
            case 1:
                $output->writeln('Sending email ...');
                $this->eventDispatcher->dispatch($this->sendMailEvent);
                $output->writeln('The e-mail was sent successfully...');
                break;
            default:
                return Command::INVALID;
                break;
        }

        return Command::SUCCESS;
    }
}