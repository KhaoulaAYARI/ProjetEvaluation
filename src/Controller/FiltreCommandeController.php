<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFiltreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FiltreCommandeController extends AbstractController
{
    #[Route('/filtre/commande/ajax', name: 'commande_filtre')]
    public function commandesFiltre(Request $req, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $form=$this->createForm(CommandeFiltreType::class);
        $form->handleRequest($req);

//gestion de submit
        if ($form->isSubmitted()){
            $rep=$doctrine->getRepository(Commande::class);
            $resultats=$rep-> commandesFiltre($form->getData());
            $response=$serializer->serialize($resultats, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['fournisseurs', 'produits', 'evaluations']]);
            return new Response($response);
            
        }

        $vars = ['form' => $form];
        return $this->render('filtre/commandesFiltre.html.twig', $vars);
    }
}
