<?php


namespace App\Controller;


use App\Entity\Borrow;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Services\BoardGamesApi;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("game/description/{id}", name="description_game")
     * @param GameRepository $gameRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDescriptionGame(GameRepository $gameRepository, $id) {
        $game = $gameRepository->find($id);
        return $this->render('game/details.html.twig', [
            'game' => $game
        ]);
    }

    /**
     * @Route("/showcase", name="showcase_page")
     * @Method("GET")
     * @param GameRepository $gameRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(GameRepository $gameRepository) {
        $games = $gameRepository->findBy(["isBorrowed" => false]);

        return $this->render('game/list.html.twig', [
            "games" => $games
        ]);
    }

    /**
     * @Route("/deals", name="deals_page")
     * @Method("GET")
     * @param BoardGamesApi $boardGamesApi
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bestDeals(BoardGamesApi $boardGamesApi) {
        $games = $boardGamesApi->getGamesBestDeals(0.4);
        return $this->render('game/deals.html.twig', [
            "games" => $games
        ]);
    }

}