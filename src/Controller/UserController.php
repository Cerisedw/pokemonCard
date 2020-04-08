<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UpdateUserInfos;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profil", requirements={"id"="\d+"})
     */
    public function profil(int $id)
    {
        $formUser = $this->createForm(UpdateUserInfos::class, null, ['method' => 'POST', 'action' => $this->generateUrl('update-user')]);

        // dd($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT deck, card FROM App\Entity\Deck deck JOIN deck.cards card WHERE deck.idUser = :id");
        $query->setParameter(':id', $id);
        $decks = $query->getArrayResult();

        // $this->getUser()->setPseudo('Pikachu');
        // $em->flush();
        // dd($decks);
        return $this->render('user/profil.html.twig', ['decks' => $decks, 'form' => $formUser->createView()]);
    }

    /**
     * @Route("/user/update", name="update-user")
     */
    public function updateProfilInfo(Request $req){
        $newImg = $req->files->get('update_user_infos')["img"];
        if($newImg){
            $nomImg = md5(uniqid()) . "." . $newImg->guessExtension();
            $newImg->move('assets/img', $nomImg);
            $em = $this->getDoctrine()->getManager();
            $userCo = $this->getUser();
            $userCo->setImg($nomImg);
            $em->flush();
        }
        return $this->redirectToRoute("profil", ["id" => $userCo->getId()]); 
    }


}
