<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Evaluation;
use App\Entity\Fournisseur;
use App\Entity\DetailCommande;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/home/insert')]
    public function fournisseurInsert(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        //creation de l'objet
        $fournisseur= new Fournisseur();
        $fournisseur->setNom("Mon Premier Fournisseur");
        $fournisseur->setAdresse('Adresse Mon Premier Fournisseur 1000 Bruxelles');
        $fournisseur->setEmail('fournisseur1@gmail.com');
        
        $em->persist($fournisseur);
        $em->flush();
        dd($fournisseur);
    }

    #[Route('/home/update')]
    public function fournisseurUpdate(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();

        //creation de l'objet et insertion ds la BD
        $fournisseur= new Fournisseur();
        $fournisseur->setNom("Mon deuxieme Fournisseur");
        $fournisseur->setAdresse('Adresse Mon deuxieme Fournisseur 1000 Bruxelles');
        $fournisseur->setEmail('fournisseur2@gmail.com');
        $em->persist($fournisseur);
        $em->flush();
        //Update de fournisseur ds le domaine des objet
        $fournisseur->setEmail('fournisseurN-2@gmail.com');
        //dd($fournisseur);
    }

    #[Route('/home/select/update')]
    public function fournisseurSelectUpdate(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $rep=$em->getRepository(fournisseur::class);

        //chercher de l'objet dans la BD et le mettre à jour ds la BD
        $fournisseur=$rep->find(3);
        $fournisseur->setNom("Nouveau fournisseur");
        $em->flush();
        //dd($fournisseur);
    }

    #[Route('/home/select/all')]
    public function fournisseurSelectAll(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $rep=$em->getRepository(fournisseur::class);
        $tousfournisseurs=$rep->findAll(); 
        $em->flush();
        //dd($tousfournisseurs);
    }
    ////Creer un fournisseur avec deux evaluations
    #[Route('/home/insert/fournisseur/evaluations')]
    public function fournisseurInsertEvaluations(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $fournisseur= new Fournisseur();
        $fournisseur->setNom("Setex");
        $fournisseur->setAdresse('MG Allemagne');
        $fournisseur->setEmail('Setex@gmail.com');

        $evaluation1= new Evaluation();
        $evaluation1->setNote(5);
        $evaluation1->setCommentaire("un bon fournisseur de tissu");

        $evaluation2= new Evaluation();
        $evaluation2->setNote(1);
        $evaluation2->setCommentaire("un mauvais etat des depots");
        $fournisseur->addEvaluation($evaluation1);
        $fournisseur->addEvaluation($evaluation2);

        $em->persist($fournisseur);
        $em->persist($evaluation1);
        $em->persist($evaluation2);
        $em->flush();
        dd($fournisseur);
    }

    #[Route('/home/delete/fournisseur/evaluations')]
    public function fournisseurDeleteEvaluations(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        //on obtient le fournisseur d'abord
        $rep=$em->getRepository(Fournisseur::class);
        $fournisseur=$rep->find(5);
        //on efface le fournisseur
        $em->remove($fournisseur);
        $em->flush();
        dd($fournisseur);

    }

    ////Creer un fournisseur avec trois produits
    #[Route('/home/insert/fournisseur/produits')]
    public function fournisseurInsertProduits(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $fournisseur= new Fournisseur();
        $fournisseur->setNom("Coton Styles");
        $fournisseur->setAdresse('MG Allemagne');
        $fournisseur->setEmail('CStyles@gmail.com');

        $produit1= new Produit();
        $produit1->setMatricule("1235PO");
        $produit1->setDescription('tissu');
        $produit1->setPrix(10.5);
        $fournisseur->addProduitsF($produit1);
        

        $produit2= new Produit();
        $produit2->setMatricule("1235PO");
        $produit2->setDescription('tissu');
        $produit2->setPrix(18.2);
        $fournisseur->addProduitsF($produit2);

        //si on met cascade: ['persist', 'remove'] dans l'entité coté 1 donc on ne met pas persist pour les objets coté N
        $em->persist($fournisseur);
        $em->persist($produit1);
        $em->persist($produit2);
        $em->flush();
        dd($fournisseur);
    }

    ////Creer un fournisseur avec trois commandes
    #[Route('/home/insert/fournisseur/commandes')]
    public function fournisseurInsertCommandes(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $fournisseur= new Fournisseur();
        $fournisseur->setNom("Santandarina");
        $fournisseur->setAdresse('MG Allemagne');
        $fournisseur->setEmail('Santandarina@gmail.com');

        $commande1= new Commande();
        $commande1->setNumero(25896);
        $commande1->setDateCommande(new \DateTime());
        $commande1->setStatutCommande("En cours");
        
        $fournisseur->addCommande($commande1);
        
        $commande2= new Commande();
        $commande2->setNumero(89777);
        $commande2->setDateCommande(new \DateTime());
        $commande2->setStatutCommande("En cours");
        
        $fournisseur->addCommande($commande2);

        //si on met cascade: ['persist', 'remove'] dans l'entité coté 1 donc on ne met pas persist pour les objets coté N
        $em->persist($fournisseur);
        $em->persist($commande1);
        $em->persist($commande2);
        $em->flush();
        dd($fournisseur);
    }

    ////Creer une commande avec deux details commandes
    #[Route('/home/insert/commande/details')]
    public function commandeInsertDetails(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $commande= new Commande();
        $commande->setNumero(25800);
        $commande->setDateCommande(new \DateTime());
        $commande->setStatutCommande("En cours");
        
        $detail1= new DetailCommande();
        $detail1->setQuantite(5);
        $detail1->setPrixUnitaire(10.5);
        
        $commande->addCommandeDetailCommande($detail1);

        $em->persist($commande);
        //si on met cascade: ['persist', 'remove'] dans l'entité coté 1 donc on ne met pas persist pour les objets coté N
        $em->persist($detail1);
        $em->flush();
        dd($commande);

    }
}

