<?php

namespace App\Controller;

use App\Entity\Ability;
use App\Entity\Attack;
use App\Entity\Card;
use App\Entity\Type;
use App\Entity\Weakness;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiCardController extends AbstractController
{
    /**
     * @Route("/apiCard/addAll", name="testing")
     */
    public function AddCardFromApi()
    {
        //pour les tables intermédiaires qui ont des valeurs, il faut faire une entité pour la table intermédiaire 
        $client = HttpClient::create();
        $res = $client->request ('GET', 'https://api.pokemontcg.io/v1/cards?setCode=sma');
        $cards = $res->ToArray();
        // dd($cards["cards"]);
        $cartes = $this->apiToArrCardObject($cards["cards"]);
        // dd($cartes);
        return new Response("ok");
    }
    /**
     * @Route("/apiCard")
     */
    public function seeAllCard(){
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(Card::class);
        $cartes = $rep->findAll();
        // dd($cartes);
        return $this->render('api_card/index.html.twig', ["cartes" => $cartes]);
    }
    /**
     * @Route("/apiCard/DQL")
     */
    public function seeAllCardFromDQL(){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT card, type FROM App\Entity\Card card JOIN card.types type WHERE type.name = 'Grass'");
        dd($query->getResult());

        // dd($cartes);
        return $this->render('testing/index.html.twig', ["cartes" => $cartes]);
    }

    /**
     * @Route("/apiCard/ajoutTypes")
     */

     public function ajoutTypes(){
         $types = ["Fire","Water","Lightning","Psychic","Fighting","Darkness","Colorless","Grass","Fairy","Metal","Dragon","Free"];
         $em = $this->getDoctrine()->getManager();
         foreach($types as $t){
             $typeDb = new Type();
             $typeDb->setName($t);
            //  $em->persist($typeDb);
         }
        //  $em->flush();
         return new Response("OK");
     }





     private function apiToArrCardObject(array $arr){
        $em = $this->getDoctrine()->getManager();
        $newCardArray = [];
        foreach($arr as $carte){
            $carteObjet = new Card($carte);
            $carteObjet->setCode($carte["id"]);
            $carteObjet->setSetCollection($carte["set"]);
            $this->ajoutTypeToCard($carte, $carteObjet);
            $this->ajoutAttackToCard($carte, $carteObjet);
            $this->ajoutWeaknessToCard($carte, $carteObjet);
            $this->ajoutAbilityToCard($carte, $carteObjet);
            // $em->persist($carteObjet);
            $newCardArray[] = $carteObjet;
        }
        // $em->flush();
        return $newCardArray;
     }

     private function ajoutTypeToCard(array $carteArr, Card $carteDb){
        $em = $this->getDoctrine()->getManager();
        if(array_key_exists('types', $carteArr)){
            $rep = $em->getRepository(Type::class);
            foreach($carteArr["types"] as $type){
                $t = $rep->findBy(["name" => $type]);
                $carteDb->addType($t["0"]);
            }    
        }
     }

     private function ajoutAttackToCard(array $carteArr, Card $carteDb){
        $em = $this->getDoctrine()->getManager();
        if(array_key_exists('attacks', $carteArr)){
            $rep = $em->getRepository(Type::class);
            foreach($carteArr["attacks"] as $attack){
                $a = new Attack($attack);
                if(array_key_exists('cost', $attack)){
                    foreach($attack["cost"] as $ty){
                        $t2 = $rep->findBy(["name" => $ty]);
                        if(array_key_exists('0',$t2)){$a->addCost($t2["0"]);}
                        else{dd($ty);}
                    }    
                }
                $carteDb->addAttack($a);
            }    
        }
     }

     private function ajoutWeaknessToCard(array $carteArr, Card $carteDb){
         $em = $this->getDoctrine()->getManager();
         if(array_key_exists('weaknesses', $carteArr)){
             $rep = $em->getRepository(Type::class);
             foreach($carteArr["weaknesses"] as $weak){
                //  dd($weak);
                 $w = new Weakness($weak);
                 $t3 = $rep->findBy(["name" => $weak["type"]]);
                //  dd($t3);
                 $w->setTypeweak($t3["0"]);
                //  dd($w);
                $carteDb->setWeakness($w);
             }
         }
     }

     private function ajoutAbilityToCard(array $carteArr, Card $carteDb){
        if(array_key_exists('ability', $carteArr)){
            $a = new Ability($carteArr['ability']);
            $carteDb->setAbilities($a);
        }
    }

}
