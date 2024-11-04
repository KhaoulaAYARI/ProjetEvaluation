<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DetailCommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //obtenier tous les elements de coté1 "Commande"
        $rep=$manager->getRepository(Commande::class);
        $toutesLesCommandes=$rep->findAll();
        //obtenier tous les elements de coté1 "Produit":
        $rep=$manager->getRepository(Produit::class);
        $tousLesProduits=$rep->findAll();

        $faker=Factory::create("fr_BE");
   // Pour chaque commande, créer des détails de commande
        foreach ($toutesLesCommandes as $commande) {
             // Assigner plusieurs produits à chaque commande
             for ($i = 0; $i < rand(1, 5); $i++) { // Par exemple, 1 à 5 produits par commande
                $detailCommande = new DetailCommande(
            [
                'quantite'=>rand(5,100),
                'prixUnitaire'=>$faker->randomFloat(2, 10, 30),
            ]
        );
          // Assigner la commande courante
          $detailCommande->setCommandesD($commande);
    
        //fixer l'element de l'entite de coté1 "Commande":
        //$detailCommande->setCommandesD($toutesLesCommandes[rand(0, count($toutesLesCommandes)-1)]);
        //$manager->persist($detailCommande);
        //fixer l'element de l'entite de coté1 "Produit":
        $detailCommande->setProduits($tousLesProduits[rand(0, count($tousLesProduits)-1)]);
        $manager->persist($detailCommande);
        } }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CommandeFixtures::class,
            ProduitsFixtures::class
        ];
    }
}
