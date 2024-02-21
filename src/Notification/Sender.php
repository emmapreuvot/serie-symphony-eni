<?php

namespace App\Notification;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{

    public function __construct(protected MailerInterface $mailer)
    {
    }

    public function sendNewUserNotifToAdmin(User $user): void
    {
        //pour tester
        //file_put_contents('debug.txt',$user->getEmail());

        $message = new Email();
        $message->from('accounts@series.com')
            ->to('admin@series.com')
            ->subject('new account created on Series.com !')
            ->html('<h1>New account</h1> <br> ' . $user->getEmail());

        $this->mailer->send($message);
    }
}