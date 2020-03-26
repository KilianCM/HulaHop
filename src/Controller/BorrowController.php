<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\BorrowRepository;
use App\Repository\GameRepository;
use App\Service\MailerManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


class MailerController
{
    /**
     * @Route("/borrows/return_game/{id}", name="return_game")
     * @param MailerManager $mailerManager
     * @param BorrowRepository $borrowRepository
     * @param $id
     * @return RedirectResponse
     */
    public function sendMail(MailerManager $mailerManager, BorrowRepository $borrowRepository, $id)
    {
        $borrow = $borrowRepository->find($id);
        $mailerManager->createMail($borrow);
        return new RedirectResponse("/");
    }
}