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
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $twentycartes = $query->setMaxResults(20)->setFirstResult(0)->getResult();
        // $cartes = $query->getResult();
        $nmbMaxPage = $this->getNmbPageMax(20);
        // dd($nmbpage);
        // dd($cartes);
        return $this->render('card/index.html.twig', ["cartes" => $twentycartes, "nmbpage" => $nmbMaxPage]);
    }
    /**
     * @Route("/card/getByType", options={"expose"=true}, name="getByTypeId")
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
    
    /**
     * @Route("/card/page/using", options={"expose"=true}, name="getAllByPage")
     */
    public function usePage(Request $req){
        $page = (int)$req->request->get("page") - 1;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $cartes = $query->setMaxResults(20)->setFirstResult(20 * $page)->getArrayResult();
        return new JsonResponse($cartes);
    }

    
    /**
     * @Route("/card/{id}", options={"expose"=true}, name="cardInfo")
     */
    public function infoCard(int $id){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card, type, attack, weakness FROM App\Entity\Card card JOIN card.types type JOIN card.attacks attack JOIN card.weakness weakness WHERE card.id = :id");
        $query->setParameter(':id', $id);
        $carte = $query->getArrayResult();
        dd($carte);
        return $this->render('card/cardinfo.html.twig', ["cartes" => $twentycartes, "nmbpage" => $nmbMaxPage]);
    }


    private function getNmbPageMax(int $imgPerPage){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $nmbMaxPage = count($query->getResult()) / $imgPerPage;
        return (int)$nmbMaxPage;
    }

}
