<?php


namespace App\Controller;


use App\Entity\Game;
use App\Entity\Rating;
use App\Entity\User;
use App\Forms\RatingFormType;
use App\Repository\GameRepository;
use App\Repository\RatingRepository;
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
     * @param Rating $rating
     * @param Game $game
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function createRating(Rating $rating, Game $game, EntityManagerInterface $entityManager, Request $request) {
        $form = $this->createForm(RatingFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $rating = new Rating();
            $rating->setUser($this->getUser());
            $rating->setGame($game);
            $rating->setComment($form->get("comment")->getData());
            $rating->setNote($form->get("rating")->getData());
            $entityManager->persist($rating);

            $entityManager->flush();

            //return new RedirectResponse("/game/description/{id}");
        }

        return $this->render("rating/rating.html.twig", [
            "form" => $form->createView(),
            "rating" => $rating,
            "game" => $game
        ]);

    }

}