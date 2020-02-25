<?php


namespace App\Controller;


use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     * @Method("GET")
     * @param GameRepository $gameRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(GameRepository $gameRepository) {
        $games = $gameRepository->findBy(["isBorrowed" => false]);

        return $this->render('home/index.html.twig', [
            "games" => $games
        ]);
    }
}