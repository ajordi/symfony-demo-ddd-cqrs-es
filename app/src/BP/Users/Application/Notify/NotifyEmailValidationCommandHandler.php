<?php

namespace App\BP\Users\Application\Notify;

use Broadway\CommandHandling\SimpleCommandHandler;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class NotifyEmailValidationCommandHandler extends SimpleCommandHandler
{
    public function handleNotifyEmailValidationCommand(NotifyEmailValidationCommand $command)
    {
        // @TODO: inject mailer
        $transport = (new Swift_SmtpTransport('mail', 1025));
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message())
            ->setSubject('Your subject')
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
            ->setBody(sprintf('Event: user.registered uuid: %s', $command->uuid()))
        ;

        $mailer->send($message);
    }
}
