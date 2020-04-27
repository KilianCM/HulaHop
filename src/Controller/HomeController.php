<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function home(){
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/about", name="about_page")
     */
    public function about() {
        return $this->render('about/index.html.twig');
    }

    /**
     * @Route("/legals", name="legals_page")
     */
    public function legals() {
        return $this->render('about/legals.html.twig');
    }


}