<?php
namespace App\EventSubscriber;

use App\Event\SendMailEvent;
use App\Strategies\SendMailStrategy;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendMailSubscriber implements EventSubscriberInterface
{
    private SendMailStrategy $sendMailStrategy;

    /**
     * @param SendMailStrategy $sendMailStrategy
     */
    public function __construct(SendMailStrategy $sendMailStrategy)
    {
        $this->sendMailStrategy = $sendMailStrategy;
    }

    /**
     * @return \string[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SendMailEvent::class => [
                ['onSendMail', 1]
            ]
        ];
    }

    /**
     * @return void
     */
    public function onSendMail(): void
    {
        $this->sendMailStrategy->sendMail('Random subject');
    }
}