<?php


namespace App\Controller;


use App\Forms\AddressFormType;
use App\Forms\ContactFormType;
use App\Repository\UserRepository;
use App\Services\PhotonApi;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param PhotonApi $photonApi
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function findGamers(Request $request, PhotonApi $photonApi, EntityManagerInterface $entityManager) {
        $form = $this->createForm(AddressFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $address = $form->get("address")->getData();
            $this->getUser()->setAddress($address);
            $coordinates = $photonApi->transformAddressToCoordinate($address);
            $this->getUser()->setLatitude($coordinates[1]);
            $this->getUser()->setLongitude($coordinates[0]);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUserCoordinates(UserRepository $userRepository, SerializerInterface $serializer) {
        $users = $userRepository->findAllWithoutCurrent($this->getUser()->getId());
        return $this->json([
            "currentUser" => $serializer->serialize($this->getUser(), 'json', ['groups' => ['user']]),
            "otherUsers" => $users
        ]);
    }
}