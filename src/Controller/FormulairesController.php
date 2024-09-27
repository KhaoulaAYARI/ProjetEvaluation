<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FormulairesController extends AbstractController
{
    #[Route('/formulaires', name: 'app_formulaires')]
    public function index(): Response
    {
        return $this->render('formulaires/index.html.twig');
    }

    #[Route('/formulaires/Fournisseur/afficher')]
    public function afficherfournisseur(Request $req, ManagerRegistry $doctrine){

        //creer une entité vide
        $fournisseur = new Fournisseur();

        //creer le form et associer l'entité au form
        $form=$this->createForm(FournisseurType::class, $fournisseur);
        
        //gerer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);

        //si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($fournisseur);
            $em->flush();
        }
        
        $vars=['formulaireFournisseur'=>$form];
        return $this->render('formulaires/fournisseur_afficher.html.twig', $vars);
        
    }

}
