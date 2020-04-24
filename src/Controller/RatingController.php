<?php


namespace App\Controller;


use App\Entity\Game;

use App\Entity\Rating;
use App\Forms\RatingFormType;
use App\Repository\GameRepository;
use App\Repository\RatingRepository;
use App\Security\RatingVoter;
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
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function createRating(Game $game, EntityManagerInterface $entityManager, Request $request) {
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

            return new RedirectResponse("/game/description/".$rating->getGame()->getId());
        }

        return $this->render("rating/rating.html.twig", [
            "ratingForm" => $form->createView(),
            "game" => $game
        ]);

    }

    /**
     * @Route("/rating/{id}/delete", name="rating_delete")
     * @param Rating $rating
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function delete(Rating $rating, EntityManagerInterface $entityManager) {
        $this->denyAccessUnlessGranted(RatingVoter::DELETE, $rating);
        $entityManager->remove($rating);
        $entityManager->flush();

        return $this->redirectToRoute("description_game", ["id" => $rating->getGame()->getId()]);
    }

    /**
     * @Route("/rating/{id}/edit", name="rating_edit")
     * @param Rating $rating
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function edit(Rating $rating, Request $request, EntityManagerInterface $entityManager) {
        $this->denyAccessUnlessGranted(RatingVoter::EDIT, $rating);
        $form = $this->createForm(RatingFormType::class, $rating);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rating->setComment($form->get("comment")->getData());
            $rating->setNote($form->get("note")->getData());
            $entityManager->persist($rating);
            $entityManager->flush();

            return $this->redirectToRoute('description_game', ["id" => $rating->getGame()->getId()]);
        }

        return $this->render("/rating/rating.html.twig", [
            "ratingForm" => $form->createView(),
            "game" => $rating->getGame()
        ]);
    }

}