<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profil")
     */
    public function profil(int $id)
    {
        return $this->render('user/profil.html.twig');
    }
}
