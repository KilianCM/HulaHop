<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/borrows", name="user_borrows")
     * @Method("GET")
     * @return Response
     */
    public function userBorrows() {
        return $this->render('borrows/index.html.twig', [
            'borrows' => $this->getUser()->getBorrows(),
        ]);
    }

}