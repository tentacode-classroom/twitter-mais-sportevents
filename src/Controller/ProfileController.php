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

    public function profile_page(Request $request, $profileId = 1, ObjectManager $manager)
    {
        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);
        dump($profileId);
        
        $user ->followers= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFollowers($user);

        $user ->followings= $this-> getDoctrine()
        ->getRepository(Friend::class)
        ->findFollowings($user);
        
        $manager -> persist($user);
        $manager -> flush();
        
        return $this->render('/user/userPage.html.twig', [
            'user' => $user,
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
}
