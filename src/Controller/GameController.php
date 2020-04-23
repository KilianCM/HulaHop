<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Services\BoardGamesApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(GameRepository $gameRepository, CategoryRepository $categoryRepository, Request $request) {

        $categories = $categoryRepository->findAll();
        $games = $gameRepository->findBy(["isBorrowed" => false]);

        if($request->query->get("categories")) {
            $games = $gameRepository->findBy(["isBorrowed" => false, "category" => $request->query->get("categories")]);
        }

        return $this->render('game/list.html.twig', [
            "games" => $games,
            "categories" => $categories
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