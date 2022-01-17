<?php

namespace App\Service;

use App\Application\Command\Mailer\SendEmailCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class MailerService
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function send(string $title, string $content, array $recipients = [])
    {
        foreach($recipients as $recipient)
        {
            $sendEmailCommand = new SendEmailCommand(
                $title,
                $content,
                $recipient
            );

            //TODO ASYNC
            $this->commandBus->dispatch($sendEmailCommand);
        }
    }
}
