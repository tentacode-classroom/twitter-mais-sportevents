<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
class SearchController extends AbstractController
{
    /**
     * @Route("/search/", name="search")
     */
    public function search(Request $request)
    {
        $word=$request->get('search');

        $users = $this-> getDoctrine()
        ->getRepository(User::class)
        ->findUsersStartingBy($word);

        return $this->render('search/index.html.twig', [
            'users' => $users,
        ]);
    }
}
