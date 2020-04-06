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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT deck, card FROM App\Entity\Deck deck JOIN deck.cards card WHERE deck.idUser = :id");
        $query->setParameter(':id', $id);
        $decks = $query->getArrayResult();
        // dd($decks);
        return $this->render('user/profil.html.twig', ['decks' => $decks]);
    }
}
