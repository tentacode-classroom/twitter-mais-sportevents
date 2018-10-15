<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
       /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
         // creates a task and gives it some dummy data for this example
            $user = new User();
    
            $form = $this->createFormBuilder($user)
                ->add('firstname', TextType::class, array('label' => 'Prénom'))
                ->add('lastname', TextType::class,array('label' => 'Nom') )
                ->add('email', EmailType::class, array('label' => 'Email'))
                ->add('password', PasswordType::class, array('label' => 'Mot de Passe'))
                ->add('username', TextType::class, array('label' => 'Nom d\'utilisateur'))
                ->add('save', SubmitType::class, array('label' => 'Créer mon Compte'))
                ->getForm();
            
            $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $user = $form->getData();
                    $plainPassword= $user->getPassword();
                    $encryptedPassword = $encoder->encodePassword($user, $plainPassword);
                    $user->setPassword($encryptedPassword);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
            
                    return $this->redirectToRoute('login');
                }
            return $this->render('user/registration.html.twig', array(
                'form' => $form->createView(),
            ));
    }
}
