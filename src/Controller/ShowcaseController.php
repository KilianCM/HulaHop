<?php


namespace App\Controller;


use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowcaseController extends AbstractController
{
    /**
     * @Route("/showcase", name="showcase_page")
     * @Method("GET")
     * @param GameRepository $gameRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showcase(GameRepository $gameRepository) {
        $games = $gameRepository->findBy(["isBorrowed" => false]);

        return $this->render('showcase/index.html.twig', [
            "games" => $games
        ]);
    }
}