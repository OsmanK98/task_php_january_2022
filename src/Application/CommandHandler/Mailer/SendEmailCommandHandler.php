<?php

namespace App\Application\CommandHandler\Mailer;

use App\Application\Command\Mailer\SendEmailCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendEmailCommandHandler implements CommandHandlerInterface
{
    public function __construct(private MailerInterface    $mailer,
                                private ContainerInterface $container)
    {
    }

    public function __invoke(SendEmailCommand $command)
    {
        $email = new Email();
        $email->from($this->container->getParameter('system_email'));
        $email->to($command->getEmail());
        $email->subject($command->getTitle());
        $email->text($command->getDescription());
        try {
            $this->mailer->send($email);
        } catch (\Exception) {
           throw new \Exception('Problem with send email action, check you SMTP configuration!');
        }
    }
}
