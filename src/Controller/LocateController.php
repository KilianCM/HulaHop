<?php


namespace App\Controller;


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
        return $this->render('locate/index.html.twig');
    }
}