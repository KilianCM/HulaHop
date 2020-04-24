<?php


namespace App\Controller;


use App\Entity\Game;

use App\Entity\Rating;
use App\Forms\RatingFormType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    /**
     * @Route("/rating/add/{id}", name="rating_game")
     * @param Game $game
     * @param GameRepository $gameRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function createRating(Game $game, GameRepository $gameRepository, EntityManagerInterface $entityManager, Request $request, $id) {
        $form = $this->createForm(RatingFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $rating = new Rating();
            $rating->setUser($this->getUser());
            $rating->setGame($game);
            $rating->setComment($form->get("comment")->getData());
            $rating->setNote($form->get("note")->getData());

            $entityManager->persist($rating);

            $entityManager->flush();
            $game = $gameRepository->find($id);
            return new RedirectResponse("/game/description/".$game->getId());
        }

        return $this->render("rating/rating.html.twig", [
            "ratingForm" => $form->createView(),
            "game" => $game
        ]);

    }

    /**
     * @Route("/rating/edit/{id}", name="rating_post")
     *
     */
    public function editRating() {

    }

}