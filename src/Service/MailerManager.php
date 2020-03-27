<?php


namespace App\Service;


use App\Entity\Borrow;
use App\Form\ContactFormType;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerManager
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function createMail(Borrow $borrow)
    {

        $email = ( new Email())
            ->from(new Address("thiebaultbebert@gmail.com"))
            ->to(new Address($borrow->getUser()))
            ->subject("Consigne de retour de jeu")
            ->text("Veuillez suivre ces étapes pour rendre ce jeu".$borrow->getGame());

        $this->mailer->send($email);
    }



}