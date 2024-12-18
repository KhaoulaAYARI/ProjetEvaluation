<?php  
// ok avec syllabus 07-10-24 mais fournisseurFiltre ne fonctionne pas

namespace App\Controller;

use App\Entity\Commande;
use App\Form\FiltreType;
use App\Entity\Fournisseur;
use App\Form\CommandeFiltreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FiltreController extends AbstractController
{
    #[Route('/filtre/fournisseur/ajax', name: 'fournisseur_filtre')]
    public function fournisseurFiltre(Request $req, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $form=$this->createForm(FiltreType::class);
        $form->handleRequest($req);

//gestion de submit
        if ($form->isSubmitted()){
            $rep=$doctrine->getRepository(Fournisseur::class);
            $resultats=$rep-> fournisseurFiltre($form->getData());
            $response=$serializer->serialize($resultats, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['commandes', 'produits', 'evaluations']]);
            return new Response($response);
            
        }

        $vars = ['form' => $form];
        return $this->render('filtre/fournisseurFiltre.html.twig', $vars);
    }

//     #[Route('/filtre/commandes/ajax', name: 'commandes_filtre')]
//     public function commandesFiltre(Request $req, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
//     {
//         $form=$this->createForm(CommandeFiltreType::class);
//         $form->handleRequest($req);

// //gestion de submit
//         if ($form->isSubmitted()){
//             $rep=$doctrine->getRepository(Commande::class);
//             $resultats=$rep-> commandesFiltre($form->getData());
//             $response=$serializer->serialize($resultats, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['fournisseurs', 'produits', 'evaluations']]);
//             return new Response($response);
            
//         }

//         $vars = ['form' => $form];
//         return $this->render('filtre/commandesFiltre.html.twig', $vars);
//     }
 }
