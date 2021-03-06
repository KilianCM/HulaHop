<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\RatingRepository;
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
     * @param RatingRepository $ratingRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDescriptionGame(GameRepository $gameRepository, $id, RatingRepository $ratingRepository)
    {
        $game = $gameRepository->find($id);
        $ratings = $ratingRepository->findBy(['game' => $id]);
        return $this->render('game/details.html.twig', [
            'game' => $game,
            'ratings' => $ratings
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
    public function list(GameRepository $gameRepository, CategoryRepository $categoryRepository, Request $request)
    {
        $categories = $categoryRepository->findAll();
        $categoriesParam = $request->query->get("categories");
        if ($categoriesParam) {
            $categoriesParam = explode(",",$categoriesParam);
            $games = $gameRepository->findAllByCategories($categoriesParam);
        } else {
            $games = $gameRepository->findAll();
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
    public function bestDeals(BoardGamesApi $boardGamesApi)
    {
        $games = $boardGamesApi->getGamesBestDeals(0.4);
        return $this->render('game/deals.html.twig', [
            "games" => $games
        ]);
    }

}