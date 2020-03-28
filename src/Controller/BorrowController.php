<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Services\MailerManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BorrowController extends AbstractController
{
    /**
     * @Route("/borrows/return/{id}", name="return_game")
     * @param MailerManager $mailerManager
     * @param Borrow $borrow
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function return(
        MailerManager $mailerManager,
        Borrow $borrow,
        EntityManagerInterface $entityManager
    )
    {
        $borrow->setIsReturned(true);
        $entityManager->persist($borrow);
        $entityManager->flush();
        $mailerManager->sendReturnGameMail($borrow);
        return new RedirectResponse("/");
    }

    /**
     * @Route("/borrows", name="user_borrows")
     * @Method("GET")
     * @return Response
     */
    public function userBorrows() {
        return $this->render('borrows/index.html.twig', [
            'borrows' => $this->getUser()->getBorrows(),
        ]);
    }
}