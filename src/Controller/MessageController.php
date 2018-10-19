<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Like;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/like/{{messageId}}", name="like_message")
     */
    public function like(Request $request, $messageId = 1,UserInterface $userInterface)
    {
        $loggedUser= $this->getDoctrine()
        ->getRepository(User::class)
        ->findByUsername($userInterface->getUsername());

        $message = $this-> getDoctrine()
        ->getRepository(Message::class)
        ->find($messageId);

        $like = new Like();
        $like ->setUser($loggedUser);
        $like -> setMessage($message);

    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->persist($message);
        $entityManager->flush();

        $previousUrl = $request->server->get('HTTP_REFERER');
        return $this->redirect($previousUrl);
    }

     /**
     * @Route("/message/dislike/{{messageId}/{likeId})", name="dislike_message")
     */
    public function dislike(Request $request, $messageId = 1,$likeId=1,UserInterface $userInterface)
    {
        $loggedUser= $this->getDoctrine()
        ->getRepository(User::class)
        ->findByUsername($userInterface->getUsername());

        $message = $this-> getDoctrine()
        ->getRepository(Message::class)
        ->find($messageId);
        
        $like = $this-> getDoctrine()
        ->getRepository(Like::class)
        ->find($likeId);

        $message -> removeLike($like);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        
        $previousUrl = $request->server->get('HTTP_REFERER');
        return $this->redirect($previousUrl);
    }

}
