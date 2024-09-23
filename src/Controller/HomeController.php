<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
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
        dd($fournisseur);
    }

    #[Route('/home/select/all')]
    public function fournisseurSelectAll(ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $rep=$em->getRepository(fournisseur::class);
        $tousfournisseurs=$rep->findAll(); 
        $em->flush();
        dd($tousfournisseurs);
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
        $fournisseur->addEvaluationsFournisseur($evaluation1);
        $fournisseur->addEvaluationsFournisseur($evaluation2);

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
}
