<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\ProduitType;
use App\Entity\Evaluation;
use App\Form\CommandeType;
use App\Entity\Fournisseur;
use App\Form\EvaluationType;
use App\Form\FournisseurType;
use App\Entity\DetailCommande;
use App\Form\DetailCommandeType;
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

    #[Route('/formulaires/fournisseur/afficher')]
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
        //possibilité de renvoyer vers une autre vue
        //return $this->render('formulaires/une_autre_vue.html.twig');
        }
        
        $vars=['formulaireFournisseur'=>$form];
        return $this->render('formulaires/fournisseur_afficher.html.twig', $vars);
        
    }
    ///////////FORMULAIRE INSERER PRODUIT///////////
    #[Route('/formulaires/produit/inserer')]
    public function insererProduit(Request $req, ManagerRegistry $doctrine){
        //creer une entité vide
        $produit = new Produit();
        //creer le form et associer l'entité au form
        $form=$this->createForm(ProduitType::class, $produit);
        //gerer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);
        //si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($produit);
            $em->flush();
        }
        $vars=['formulaireProduit'=>$form];
        return $this->render('formulaires/produit_inserer.html.twig', $vars);
    }

    ///////////FORMULAIRE INSERER COMMANDE///////////
    #[Route('/formulaires/commande/inserer')]
    public function insererCommande(Request $req, ManagerRegistry $doctrine){
        //creer une entité vide
        $commande = new Commande();
        //creer le form et associer l'entité au form
        $form=$this->createForm(CommandeType::class, $commande);
        //gerer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);
        //si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();
        }
        $vars=['formulaireCommande'=>$form];
        return $this->render('formulaires/commande_inserer.html.twig', $vars);
    }

    ///////////FORMULAIRE INSERER DETAILCOMMANDE///////////
    #[Route('/formulaires/detailcommande/inserer')]
    public function insererDetailCommande(Request $req, ManagerRegistry $doctrine){
        //creer une entité vide
        $detailcommande = new DetailCommande();
        //creer le form et associer l'entité au form
        $form=$this->createForm(DetailCommandeType::class, $detailcommande);
        //gerer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);
        //si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($detailcommande);
            $em->flush();
        }
        $vars=['formulaireDetailCommande'=>$form];
        return $this->render('formulaires/detailcommande_inserer.html.twig', $vars);
    }

    ///////////FORMULAIRE INSERER Evaluation///////////
    #[Route('/formulaires/evaluation/inserer')]
    public function insererEvaluation(Request $req, ManagerRegistry $doctrine){
        //creer une entité vide
        $evaluation = new Evaluation();
        //creer le form et associer l'entité au form
        $form=$this->createForm(EvaluationType::class, $evaluation);
        //gerer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);
        //si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($evaluation);
            $em->flush();
        }
        $vars=['formulaireEvaluation'=>$form];
        return $this->render('formulaires/evaluation_inserer.html.twig', $vars);
    }


}
