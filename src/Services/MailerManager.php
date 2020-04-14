<?php


namespace App\Services;

use App\Entity\Borrow;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerManager
{
    private $mailer;
    private $hulaHopAddress;
    private $parameterBag;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $parameterBag, string $hulaHopAddress)
    {
        $this->mailer = $mailer;
        $this->parameterBag = $parameterBag;
        $this->hulaHopAddress = $hulaHopAddress;
    }

    public function sendReturnGameMail(Borrow $borrow)
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->hulaHopAddress))
            ->to(new Address($borrow->getUser()))
            ->subject("Consignes de retour de jeu")
            ->htmlTemplate('emails/return_game.html.twig')
            // fictive colissimo label
            ->attachFromPath($this->parameterBag->get('kernel.project_dir') . "/public/colissimo-sample.pdf")
            ->context([
                'return_limit_date' => new \DateTime('+7 days'),
                'game' => $borrow->getGame(),
            ]);

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