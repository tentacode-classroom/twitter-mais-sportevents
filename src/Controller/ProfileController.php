<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Friend;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @Route("profile")
 */

class ProfileController extends AbstractController
{

    /**
     * @Route("/{profileId}", name="profile")
     */

    public function profile_page(Request $request, $profileId = 1,UserInterface $userInterface)
    {
        $loggedUser= $this->getDoctrine()
        ->getRepository(User::class)
        ->findByUsername($userInterface->getUsername());

        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);
        
        $user ->followers= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFollowers($user);

        $user ->followings= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFollowings($user);

        $friend= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFriendby($user, $loggedUser);
        
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();;
        
        return $this->render('/user/userPage.html.twig', [
            'user' => $user,
            'friend'=> $friend
        ]);
    }

      /**
     * @Route("/{profileId}/follow", name="follow")
     */
    public function follow(Request $request, $profileId= 1,UserInterface $userInterface )
    {
    
        $loggedUser= $this->getDoctrine()
            ->getRepository(User::class)
            ->findByUsername($userInterface->getUsername());
               
        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);

        $friend= new Friend();
        $friend -> setFollower($loggedUser);
        $friend -> setFollowing($user);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($friend);
        $entityManager->persist($user);
        $entityManager->persist($loggedUser);
        $entityManager->flush();
   
        $previousUrl = $request->server->get('HTTP_REFERER');
        return $this->redirect($previousUrl);
    }

     /**
     * @Route("/{profileId}/unfollow", name="unfollow")
     */
    public function unfollow(Request $request, $profileId= 1,UserInterface $userInterface )
    {
    
        $loggedUser= $this->getDoctrine()
            ->getRepository(User::class)
            ->findByUsername($userInterface->getUsername());
               
        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);

        $friend= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFriendby($user, $loggedUser);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($friend);
        $entityManager->flush();
   
        $previousUrl = $request->server->get('HTTP_REFERER');
        return $this->redirect($previousUrl);
    }
}
