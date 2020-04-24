<?php


namespace App\Controller;


use App\Forms\AddressFormType;
use App\Repository\UserRepository;
use App\Services\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class LocateController extends AbstractController
{
    /**
     * @Route("/locate", name="locate_gamers")
     * @Method("GET")
     * @param Request $request
     * @param UserManager $manager
     * @return Response
     */
    public function findGamers(Request $request, UserManager $manager)
    {
        $form = $this->createForm(AddressFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->get("address")->getData();
            $city = $form->get("city")->getData();
            $postalCode = $form->get("postalCode")->getData();
            $manager->addAddress($this->getUser(), $address, $city, $postalCode);

            return new RedirectResponse("/locate");
        }

        return $this->render('locate/index.html.twig', [
            "addressForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/locate/user", name="get_user_coordinate")
     * @Method("GET")
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUserCoordinates(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAllWithoutCurrentAndFriends(
            $this->getUser()->getId(),
            $this->getUser()->getFriends()
        );

        return $this->json([
            "currentUser" => $serializer->serialize($this->getUser(), 'json', ['groups' => ['user']]),
            "friends" => $this->getUser()->getFriends(),
            "otherUsers" => $users
        ]);
    }
}