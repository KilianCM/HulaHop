<?php


namespace App\Controller;


use App\Services\PhotonApi;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LocateController extends AbstractController
{
    /**
     * @Route("/locate", name="locate_gamers")
     * @Method("GET")
     * @return Response
     */
    public function findGamers() {
        return $this->render('locate/index.html.twig', [
            "latitude" => $this->getUser()->getLatitude(),
            "longitude" => $this->getUser()->getLongitude()
        ]);
    }

    /**
     * @Route("/locate/add", name="add_user_address")
     * @Method("GET")
     * @param PhotonApi $photonApi
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
     */
    public function getUserCoordinate() {
        return $this->json([$this->getUser()->getLatitude(), $this->getUser()->getLongitude()]);
    }
}