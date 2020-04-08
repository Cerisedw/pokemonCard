<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\CreateDeck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{


    /**
     * @Route("/deck/create", name="deck-create")
     */
    public function createDeckForm(Request $req){
        $deck = new Deck();
        $formDeck = $this->createForm(CreateDeck::class, $deck, ['method' => 'POST', 'action' => $this->generateUrl('deck-create')]);
        $formDeck->handleRequest($req);

        if($formDeck->isSubmitted() && $formDeck->isValid()){
            $userCo = $this->getUser();
            $deck->setIdUser($userCo);
            // dd($deck);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deck);
            $entityManager->flush();
            return $this->redirectToRoute("profil", ["id" => $userCo->getId()]); 
        }
        return $this->render('deck/create-deck.html.twig', ['form' => $formDeck->createView()]);
    }

}
