<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * JSON expected : { "user": <id> }
     * @Route("/friend/add", name="add_friend")
     * @Method("POST")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addFriend(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager) {
        $content = json_decode($request->getContent(), true);
        $user = $userRepository->find($content["user"]);
        if(!$user) {
            return new Response("User not found", Response::HTTP_NOT_FOUND);
        }
        $this->getUser()->addFriend($user);
        $entityManager->persist($this->getUser());
        $entityManager->flush();

        return new Response("Friend added", Response::HTTP_OK);
    }

    /**
     * @Route("/profile", name="user_profile")
     * @return Response
     */
    public function profile(){
        return $this->render('user/profile.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/friends", name="user_friends")
     * @return Response
     */
    public function userFriends(){
        return $this->render('user/friends.html.twig');
    }

    /**
     * @Route("/friends/{user}", name="friend_profile")
     * @param User $user
     * @return Response
     */
    public function friendProfile(User $user){
        return $this->render('user/friend_profile.html.twig', [
            'user' => $user
        ]);
    }

    public function editProfile($id, UserRepository $userRepository){
        $users = $userRepository->find($id);
    }



}