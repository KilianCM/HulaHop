<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Entity\Game;
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
     * @param Game $game
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function returnGame(
        MailerManager $mailerManager,
        Borrow $borrow,
        Game $game,
        EntityManagerInterface $entityManager
    )
    {
        $borrow->setIsReturned(true);
        $game->setIsBorrowed(false);
        $entityManager->persist($borrow);
        $entityManager->persist($game);
        $entityManager->flush();
        $mailerManager->sendReturnGameMail($borrow);
        return new RedirectResponse("/borrows");
    }

    /**
     * @Route("/borrows", name="user_borrows")
     * @Method("GET")
     * @return Response
     */
    public function userBorrows() {
        return $this->render('borrows/index.html.twig', [
            'borrows' => $this->getUser()->getBorrows()
        ]);
    }
}