<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Entity\User;
use App\Repository\BorrowRepository;
use App\Repository\GameRepository;
use App\Service\MailerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


class BorrowController
{
    /**
     * @Route("/borrows/returnGame/{id}", name="return_game")
     * @param MailerManager $mailerManager
     * @param BorrowRepository $borrowRepository
     * @param $id
     * @param Borrow $borrow
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function sendMail(MailerManager $mailerManager, BorrowRepository $borrowRepository, $id, Borrow $borrow, EntityManagerInterface $entityManager)
    {
        $borrow->setIsReturned(true);
        $entityManager->persist($borrow);
        $entityManager->flush();

        $borrow = $borrowRepository->find($id);
        $mailerManager->createMail($borrow);

        return new RedirectResponse("/");
    }
}