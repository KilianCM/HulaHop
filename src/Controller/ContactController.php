<?php


namespace App\Controller;


use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_page")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new Email())
                ->from(new Address($form->get("email")->getData()))
                ->to(new Address("thiebaultbebert@gmail.com"))
                ->subject($form->get("subject")->getData())
                ->text($form->get("message")->getData());

            $mailer->send($email);
        }


       return $this->render("contact/index.html.twig", [
            "contactForm" => $form->createView()
        ]);
    }
}