<?php


namespace App\Services;

use App\Entity\Borrow;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerManager
{
    private $mailer;
    private $hulaHopAddress;

    public function __construct(MailerInterface $mailer, string $hulaHopAddress)
    {
        $this->mailer = $mailer;
        $this->hulaHopAddress = $hulaHopAddress;
        dd($hulaHopAddress);
    }

    public function sendReturnGameMail(Borrow $borrow)
    {

        $email = ( new Email())
            ->from(new Address($this->hulaHopAddress))
            ->to(new Address($borrow->getUser()))
            ->subject("Consigne de retour de jeu")
            ->text("Veuillez suivre ces étapes pour rendre ce jeu".$borrow->getGame());

        $this->mailer->send($email);
    }

    public function sendContactMail($email, $subject, $message) {
        $email = (new Email())
            ->from(new Address($email))
            ->to(new Address($this->hulaHopAddress))
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }



}