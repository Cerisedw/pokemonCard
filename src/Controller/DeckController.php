<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{


    /**
     * @Route("/deck/create/{idUser}", name="deck-create")
     */
    public function createDeckForm(int $idUser){

        
        return $this->render('deck/create-deck.html.twig');
    }

}
