<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\CreateDeck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Route("/deck/{iddeck}/add", name="deck-add-card")
     */
    public function addCardToDeck(int $iddeck){
        // dd($iddeck);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT deck FROM App\Entity\Deck deck WHERE deck.id = :id");
        $query->setParameter(':id', $iddeck);
        $deck = $query->getArrayResult();

        $query2 = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $twentycartes = $query2->setMaxResults(20)->setFirstResult(0)->getResult();
        $nmbMaxPage = $this->getNmbPageMax(20);
        // dd($deck);
        return $this->render('deck/add-card.html.twig', ['deck' => $deck["0"], "cartes" => $twentycartes, "nmbpage" => $nmbMaxPage]);
    }


    /**
     * @Route("/deck/add/card", options={"expose"=true}, name="add-card-to-deck")
     */
    public function addCardToCurrentDeck(Request $req){
        $idDeck = (int)$req->request->get("iddeck");
        $idCard = (int)$req->request->get("idcard");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT deck FROM App\Entity\Deck deck WHERE deck.id = :id");
        $query->setParameter(':id', $idDeck);
        $deck = $query->getResult()["0"];

        $query2 = $em->createQuery("SELECT Card FROM App\Entity\Card Card WHERE Card.id = :idc");
        $query2->setParameter(':idc', $idCard);
        $card = $query2->getResult()["0"];

        $deck->addCard($card);
        
        $em->flush();

        return new JsonResponse("OK");
    }

    /**
     * @Route("/deck/delete/card", options={"expose"=true}, name="delete-card-to-deck")
     */
    public function deleteCardToCurrentDeck(Request $req){
        $idDeck = (int)$req->request->get("iddeck");
        $idCard = (int)$req->request->get("idcard");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT deck FROM App\Entity\Deck deck WHERE deck.id = :id");
        $query->setParameter(':id', $idDeck);
        $deck = $query->getResult()["0"];

        $query2 = $em->createQuery("SELECT Card FROM App\Entity\Card Card WHERE Card.id = :idc");
        $query2->setParameter(':idc', $idCard);
        $card = $query2->getResult()["0"];

        $deck->removeCard($card);
        
        $em->flush();

        return new JsonResponse("OK");
    }


    private function getNmbPageMax(int $imgPerPage){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $nmbMaxPage = count($query->getResult()) / $imgPerPage;
        return (int)$nmbMaxPage;
    }


}
