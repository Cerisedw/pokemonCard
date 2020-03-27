<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function getAll()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card, type FROM App\Entity\Card card JOIN card.types type");
        $cartes = $query->getResult();

        // dd($cartes);
        return $this->render('card/index.html.twig', ["cartes" => $cartes]);
    }
    /**
     * @Route("/card/getByType", name="getByTypeId")
     */
    public function getByType(Request $req)
    {
        $id = (int)substr($req->request->get("typeId"), 4);
        $em = $this->getDoctrine()->getManager();
        if($id == 0){
            $queryDB = $em->createQuery("SELECT card FROM App\Entity\Card card WHERE card.supertype = 'Trainer'");
            $cartes = $queryDB->getArrayResult();    
        }else{
            $queryDB = $em->createQuery("SELECT card, type FROM App\Entity\Card card JOIN card.types type WHERE type.id = :typeId");
            $queryDB->setParameter(':typeId', $id);
            $cartes = $queryDB->getArrayResult();    
        }
        
        // dd($cartes);
        return new JsonResponse($cartes);
    }

}
