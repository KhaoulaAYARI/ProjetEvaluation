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
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FournisseurRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\TextUI\Command;
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

                ///////////////////////////////
    ///////////FORMULAIRE INSERER FOURNISSEUR///////////
                ///////////////////////////////


    #[Route('/formulaires/fournisseur/afficher', name:'insererFournisseurs')]
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

                ///////////////////////////////
    ///////////FORMULAIRE UPDATE FOURNISSEUR///////////
                ///////////////////////////////


    //action qui affiche tous les fournisseurs
    #[Route('/formulaires/touslesfournisseurs/afficher', name:'afficherTousFournisseurs')]
    public function afficherTousFournisseurs(ManagerRegistry $doctrine){
    //obtenier tous les fournisseurs de la BD
    $em=$doctrine->getManager();
    $rep=$em->getRepository(fournisseur::class);
    $tousfournisseurs=$rep->findAll();
    //dd($tousfournisseurs);
    $vars=['tousfournisseurs'=>$tousfournisseurs];
    //Envoyer l'array de fournisseurs à la vue
    return $this->render('formulaires/tousfournisseurs_afficher.html.twig', $vars);}

   //update des fournissurs (affichage et traitement de formulaire)
    #[Route('/formulaires/touslesfournisseurs/update/{id}', name:'updateFournisseur')]
        public function updateFournisseur(Request $req, FournisseurRepository $rep, EntityManagerInterface $em){
            $id=$req->get('id');
            //chercher le fournisseur
            $fournisseur=$rep->find($id);
            //creer le form    
            $form=$this->createForm(FournisseurType::class, $fournisseur);
            $form->handleRequest($req);
            if ($form->isSubmitted() ) {
                //on a cliqué submit
                $em->flush(); 
                //dd($fournisseur);
            }
            $vars=['form'=>$form];
            return $this->render('formulaires/tousfournisseurs_update.html.twig', $vars);

        }


                    ///////////////////////////////
            ///////////FORMULAIRE DELETE FOURNISSEUR///////////
                    ///////////////////////////////


        //delete des fournissurs (affichage et traitement de formulaire)
    #[Route('/formulaires/touslesfournisseurs/delete/{id}', name:'deleteFournisseur')]
    public function deleteFournisseur(Request $req, FournisseurRepository $rep, EntityManagerInterface $em ){
        //obtenier l'id de fournisseur a effacer
        $id=$req->get('id');
        //obtenier le fournisseur de la BD
        $fournisseur=$rep->find($id);
        //lancer remove
        $em->remove($fournisseur);
        //lancer flush
        $em->flush();
        //redirection vers l'affichage
        return $this->redirectToRoute('afficherTousFournisseurs');
    }
        

            /////////////////////////////// 
    ///////////FORMULAIRE INSERER PRODUIT///////////
            ///////////////////////////////


    #[Route('/formulaires/produit/inserer', name:'insererProduits')]
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



            ///////////////////////////////
    ///////////FORMULAIRE UPDATE Produit///////////
                ///////////////////////////////


    //action qui affiche tous les produits
    #[Route('/formulaires/touslesproduits/afficher', name:'afficherTousProduits')]
    public function afficherTousProduits(ManagerRegistry $doctrine){
    //obtenier tous les produits de la BD
        $em=$doctrine->getManager();
        $rep=$em->getRepository(Produit::class);
        $touslesproduits=$rep->findAll();

        $vars=['touslesproduits'=>$touslesproduits];
    //Envoyer l'array de produits à la vue
    return $this->render('formulaires/tousproduits_afficher.html.twig', $vars);}

    //update des produits (affichage et traitement de formulaire)
    #[Route('/formulaires/touslesproduits/update/{id}', name:'updateProduit')]
        public function updateProduit(Request $req, ProduitRepository $rep, EntityManagerInterface $em){
            $id=$req->get('id');
            //chercher le produit
            $produit=$rep->find($id);
            //creer le form    
            $form=$this->createForm(ProduitType::class, $produit);
            $form->handleRequest($req);
            if ($form->isSubmitted() ) {
                //on a cliqué submit
                $em->flush(); 
                //dd($fournisseur);
            }
            $vars=['form'=>$form];
            return $this->render('formulaires/tousproduits_update.html.twig', $vars);

        }

                    ///////////////////////////////
            ///////////FORMULAIRE DELETE PRODUIT///////////
                    ///////////////////////////////


        //delete des produits (affichage et traitement de formulaire)
        #[Route('/formulaires/touslesproduits/delete/{id}', name:'deleteProduit')]
        public function deleteProduit(Request $req, ProduitRepository $rep, EntityManagerInterface $em ){
            //obtenier l'id de produit a effacer
            $id=$req->get('id');
            //obtenier le produit de la BD
            $produit=$rep->find($id);
            //lancer remove
            $em->remove($produit);
            //lancer flush
            $em->flush();
            //redirection vers l'affichage
            return $this->redirectToRoute('afficherTousProduits');
        }


                ///////////////////////////////
    ///////////FORMULAIRE INSERER COMMANDE///////////
                ///////////////////////////////


    #[Route('/formulaires/commande/inserer', name:'insererCommande')]
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




                ///////////////////////////////
    ///////////FORMULAIRE UPDATE COMMANDE///////////
                ///////////////////////////////


    //action qui affiche toutes les commandes
    #[Route('/formulaires/touteslescommandes/afficher', name:'afficherToutesCommandes')]
    public function afficherToutesCommandes(ManagerRegistry $doctrine){
    //obtenier toutes les commandes de la BD
    $em=$doctrine->getManager();
    $rep=$em->getRepository(Commande::class);
    $toutescommandes=$rep->findAll();
    //dd($toutescommandes);
    $vars=['toutescommandes'=>$toutescommandes];
    //Envoyer l'array de commandes à la vue
    return $this->render('formulaires/toutescommandes_afficher.html.twig', $vars);}

   //update des commandes (affichage et traitement de formulaire)
    #[Route('/formulaires/touteslescommandes/update/{id}', name:'updateCommande')]
        public function updateCommande(Request $req, CommandeRepository $rep, EntityManagerInterface $em){
            $id=$req->get('id');
            //chercher la commande
            $commande=$rep->find($id);
            //creer le form    
            $form=$this->createForm(CommandeType::class, $commande);
            $form->handleRequest($req);
            if ($form->isSubmitted() ) {
                //on a cliqué submit
                $em->flush(); 
                //dd($fournisseur);
            }
            $vars=['form'=>$form];
            return $this->render('formulaires/toutescommandes_update.html.twig', $vars);

        }




                     ///////////////////////////////
            ///////////FORMULAIRE DELETE COMMANDE///////////
                    ///////////////////////////////


        //delete des commandes (affichage et traitement de formulaire)
        #[Route('/formulaires/touteslescommandes/delete/{id}', name:'deleteCommande')]
        public function deleteCommande(Request $req, CommandeRepository $rep, EntityManagerInterface $em ){
            //obtenier l'id de commande a effacer
            $id=$req->get('id');
            //obtenier la commande de la BD
            $commande=$rep->find($id);
            //lancer remove
            $em->remove($commande);
            //lancer flush
            $em->flush();
            //redirection vers l'affichage
            return $this->redirectToRoute('afficherToutesCommandes');
        }




                ///////////////////////////////
    ///////////FORMULAIRE INSERER DETAILCOMMANDE///////////
                ///////////////////////////////


    #[Route('/formulaires/detailcommande/inserer', name:'insererDetailCommande')]
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



                ///////////////////////////////
    ///////////FORMULAIRE UPDATE DETAILCOMMANDE///////////
                ///////////////////////////////


    //action qui affiche tous les DETAILSCOMANDES
    #[Route('/formulaires/touslesdetailscommandes/afficher', name:'afficherTousdetailsCommandes')]
    public function afficherTousDetailsCommandes(ManagerRegistry $doctrine){
    //obtenier tous les details commandes de la BD
        $em=$doctrine->getManager();
        $rep=$em->getRepository(DetailCommande::class);
        $touslesdetailscommandes=$rep->findAll();

        $vars=['touslesdetailscommandes'=>$touslesdetailscommandes];
    //Envoyer l'array de lesdetailscommandes à la vue
    return $this->render('formulaires/touslesdetailscommandes_afficher.html.twig', $vars);}

    //update des produits (affichage et traitement de formulaire)
    #[Route('/formulaires/touslesdetailscommandes/update/{id}', name:'updateDetailsCommande')]
        public function updateDetailsCommande(Request $req, DetailCommandeRepository $rep, EntityManagerInterface $em){
            $id=$req->get('id');
            //chercher le detailcommande
            $detailcommande=$rep->find($id);
            //creer le form    
            $form=$this->createForm(DetailCommandeType::class, $detailcommande);
            $form->handleRequest($req);
            if ($form->isSubmitted() ) {
                //on a cliqué submit
                $em->flush(); 
                //dd($fournisseur);
            }
            $vars=['form'=>$form];
            return $this->render('formulaires/touslesdetailscommandes_update.html.twig', $vars);

        }
                    ///////////////////////////////
            ///////////FORMULAIRE DELETE DETAIL COMMANDE///////////
                    ///////////////////////////////


        //delete des detailscommandes (affichage et traitement de formulaire)
        #[Route('/formulaires/touslesdetailscommandes/delete/{id}', name:'deleteDetailsCommande')]
        public function deleteDetailCommande(Request $req, DetailCommandeRepository $rep, EntityManagerInterface $em ){
            //obtenier l'id de detail commande a effacer
            $id=$req->get('id');
            //obtenier le detail commande de la BD
            $detailcommande=$rep->find($id);
            //lancer remove
            $em->remove($detailcommande);
            //lancer flush
            $em->flush();
            //redirection vers l'affichage
            return $this->redirectToRoute('afficherTousdetailsCommandes');
        }






            /////////////////////////////// 
    ///////////FORMULAIRE INSERER Evaluation///////////
                ///////////////////////////////



    #[Route('/formulaires/evaluation/inserer', name:'insererEvaluation')]
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


                ///////////////////////////////
    ///////////FORMULAIRE UPDATE EVALUATION///////////
                ///////////////////////////////


    //action qui affiche toutes les evaluations
    #[Route('/formulaires/touteslesevaluations/afficher', name:'afficherToutesEvaluation')]
    public function afficherToutesEvaluations (ManagerRegistry $doctrine){
    //obtenier toutes les evaluations de la BD
    $em=$doctrine->getManager();
    $rep=$em->getRepository(Evaluation::class);
    $toutesevaluations=$rep->findAll();
    //dd($tousfournisseurs);
    $vars=['toutesevaluations'=>$toutesevaluations];
    //Envoyer l'array des evaluations à la vue
    return $this->render('formulaires/toutesevaluations_afficher.html.twig', $vars);}

   //update des fournissurs (affichage et traitement de formulaire)
    #[Route('/formulaires/touteslesevaluations/update/{id}', name:'updateEvaluation')]
        public function updateEvaluation(Request $req, EvaluationRepository $rep, EntityManagerInterface $em){
            $id=$req->get('id');
            //chercher l'evaluation
            $evaluation=$rep->find($id);
            //creer le form    
            $form=$this->createForm(EvaluationType::class, $evaluation);
            $form->handleRequest($req);
            if ($form->isSubmitted() ) {
                //on a cliqué submit
                $em->flush(); 
                //dd($fournisseur);
            }
            $vars=['form'=>$form];
            return $this->render('formulaires/toutesevaluations_update.html.twig', $vars);

        }





                    ///////////////////////////////
            ///////////FORMULAIRE DELETE EVALUATION///////////
                    ///////////////////////////////


        //delete des commandes (affichage et traitement de formulaire)
        #[Route('/formulaires/touteslesevaluations/delete/{id}', name:'deleteEvaluation')]
        public function deleteevaluation(Request $req, EvaluationRepository $rep, EntityManagerInterface $em ){
            //obtenier l'id de commande a effacer
            $id=$req->get('id');
            //obtenier la commande de la BD
            $evaluation=$rep->find($id);
            //lancer remove
            $em->remove($evaluation);
            //lancer flush
            $em->flush();
            //redirection vers l'affichage
            return $this->redirectToRoute('afficherToutesEvaluation');
        }
           
           
        


}
