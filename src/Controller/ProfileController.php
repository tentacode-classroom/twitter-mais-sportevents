<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;


class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{profileId}", name="profile")
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
     * @Route("/profile/follow/{profileId}", name="follow")
     */
    public function follow(Request $request, UserInterface $userInterface  , ObjectManager $manager, $profileId = 1)
    {
        $loggedUser= $this->getDoctrine()
            ->getRepository(User::class)
            ->findByUsername($userInterface->getUsername());
        
        
        $user = $this-> getDoctrine()
            ->getRepository(User::class)
            ->find($profileId);
        
        $user -> addFollower($loggedUser);
        $loggedUser ->addFollowing($user);
     
        return $this->render('/user/userPage.html.twig', [
            'user' => $user,
        ]);
    }
}
