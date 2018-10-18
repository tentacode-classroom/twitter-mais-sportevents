<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Entity\Message;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HomepageController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function add_message(Request $request, UserInterface $userInterface)
    {
        $loggedUser= $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBySomeField($userInterface->getUsername());

        $message = new Message();
    
        $form = $this->createFormBuilder($message)
            ->add('content', TextareaType::class)
            ->getForm();
        
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $message = $form->getData();
                $loggedUser ->addMessage($message);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($loggedUser);
                $entityManager->flush();
            }
     
        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
