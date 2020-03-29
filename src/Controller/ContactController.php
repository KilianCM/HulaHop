<?php


namespace App\Controller;


use App\Forms\ContactFormType;
use App\Services\MailerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_page")
     * @param Request $request
     * @param MailerManager $mailerManager
     * @return Response
     */
    public function contact(Request $request, MailerManager $mailerManager): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = $form->get("email")->getData();
            $subject = $form->get("subject")->getData();
            $message = $form->get("message")->getData();
            $mailerManager->sendContactMail($email,$subject,$message);
        }

       return $this->render("contact/index.html.twig", [
            "contactForm" => $form->createView()
        ]);
    }
}