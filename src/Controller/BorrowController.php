<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Services\MailerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


class BorrowController
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
}