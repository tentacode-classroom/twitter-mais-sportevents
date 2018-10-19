<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Follower;
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
        
        $manager -> persist($user);
        $manager -> flush();
        
        return $this->render('/user/userPage.html.twig', [
            'user' => $user,
        ]);
    }

      /**
     * @Route("/follow/{profileId}", name="follow")
     */
    public function follow(Request $request, $profileId= 1,UserInterface $userInterface )
    {
        $follower= new Follower();

        $loggedUser= $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBySomeField($userInterface->getUsername());
               
        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);

        $follower -> setFollower($loggedUser);
        $follower -> setFollowing($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($follower);
        $entityManager->persist($user);
        $entityManager->persist($loggedUser);
        $entityManager->flush();
   
        return $this->render('/user/userPage.html.twig', [
            'user' => $user,
        ]);
    }
}
