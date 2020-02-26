<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("game/add/{id}", name="borrow_game")
     * @param Game $game
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function borrowGame(Game $game, EntityManagerInterface $entityManager) {
        $borrow = new Borrow();
        $borrow->setUser($this->getUser());
        $borrow->setGame($game);
        $entityManager->persist($borrow);
        $game->setIsBorrowed(true);
        $entityManager->flush();

        return new RedirectResponse("/");
    }

}