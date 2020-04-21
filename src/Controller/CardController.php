<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/", name="card")
     */
    public function getAll()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $twentycartes = $query->setMaxResults(20)->setFirstResult(0)->getResult();
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
            $cartes = $queryDB->setMaxResults(20)->setFirstResult(0)->getArrayResult();    
        }else{
            $queryDB = $em->createQuery("SELECT card, type FROM App\Entity\Card card JOIN card.types type WHERE type.id = :typeId");
            $queryDB->setParameter(':typeId', $id);
            $cartes = $queryDB->setMaxResults(20)->setFirstResult(0)->getArrayResult();    
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
        $query = $em->createQuery("SELECT card, type, attack, weakness, typeweak, cost FROM App\Entity\Card card JOIN card.types type JOIN card.attacks attack JOIN attack.cost cost JOIN card.weakness weakness JOIN weakness.typeweak typeweak WHERE card.id = :id");
        $query->setParameter(':id', $id);
        if($query->getArrayResult()){
            $carte = $query->getArrayResult();
        }else{
            $queryCardTrainer = $em->createQuery("SELECT card FROM App\Entity\Card card WHERE card.id = :idTrainer");
            $queryCardTrainer->setParameter(':idTrainer', $id);
            $carte = $queryCardTrainer->getArrayResult();
            return $this->render('card/cardinfo-trainer.html.twig', ["carte" => $carte["0"]]);
        }

        $query2 = $em->createQuery("SELECT card, abilities FROM App\Entity\Card card JOIN card.abilities abilities WHERE card.id = :id2");
        $query2->setParameter(':id2', $id);
        if ($query2->getArrayResult()){
            $ability = $query2->getArrayResult()["0"]["abilities"];
        }
        else{
            $ability = null;
        }
        // $weakId = $carte["0"]["weakness"]["id"];
        // $query2 = $em->createQuery("SELECT weakness, typeweak FROM App\Entity\Weakness weakness JOIN weakness.typeweak typeweak WHERE weakness.id = :idW ");
        // $query2->setParameter(':idW', $weakId);
        // $weakness = $query2->getArrayResult();
        // dd($carte);
        return $this->render('card/cardinfo.html.twig', ["carte" => $carte["0"], "ability" => $ability]);
    }

    /**
     * @Route("/card/all/type/{idtype}", options={"expose"=true}, name="card-pagination-type", requirements={"idtype"="\d+"} )
     */
    public function paginationCardType(int $idtype, Request $req){
        $page = (int)$req->request->get("page") - 1;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card JOIN card.types type WHERE type.id = :id");
        $query->setParameter(':id', $idtype);
        $cartes = $query->setMaxResults(20)->setFirstResult(20 * $page)->getArrayResult();
        return new JsonResponse($cartes);
    }

    /**
     * @Route("/card/get/pagemax/type/{idtype}", options={"expose"=true}, name="card-maxpage-type", requirements={"idtype"="\d+"})
     */

    public function maxpagebytype(int $idtype){
        $maxPagenmb = $this->getNmbPageMaxWithType(20, $idtype);
        return new JsonResponse($maxPagenmb);
    }

    private function getNmbPageMax(int $imgPerPage){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card");
        $nmbMaxPage = count($query->getResult()) / $imgPerPage;
        return (int)$nmbMaxPage;
    }

    private function getNmbPageMaxWithType(int $imgPerPage, int $idType){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card FROM App\Entity\Card card JOIN card.types type WHERE type.id = :id");
        $query->setParameter(':id', $idType);
        $nmbMaxPage = count($query->getResult()) / $imgPerPage;
        return (int)$nmbMaxPage;
    }

}
