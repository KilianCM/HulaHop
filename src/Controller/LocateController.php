<?php


namespace App\Controller;


use App\Repository\UserRepository;
use App\Services\PhotonApi;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class LocateController extends AbstractController
{
    /**
     * @Route("/locate", name="locate_gamers")
     * @Method("GET")
     * @return Response
     */
    public function findGamers() {
        return $this->render('locate/index.html.twig');
    }

    /**
     * @Route("/locate/add", name="add_user_address")
     * @Method("GET")
     * @param PhotonApi $photonApi
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function addAddress(PhotonApi $photonApi, EntityManagerInterface $entityManager) {
        $coordinates = $photonApi->transformAddressToCoordinate("607 route de la forêt 73270 Villard sur Doron");
        $this->getUser()->setLongitude($coordinates[0]);
        $this->getUser()->setLatitude($coordinates[1]);
        $entityManager->persist($this->getUser());
        $entityManager->flush();
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