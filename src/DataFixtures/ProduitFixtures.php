<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\DetailCommandeFixtures;
use App\Entity\DetailCommande;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //obtenier ts les elts de l'entité de coté1: 
        $rep = $manager->getRepository(Fournisseur::class);
        $tousLesfournisseurs = $rep->findAll();

        $faker = Factory::create("fr_BE");

        for ($i = 0; $i < 100; $i++) {
            $produit = new Produit(
                [
                    'matriculeProduit' => $faker->ean8(),
                    'description' => $faker->sentence(3),
                    'prixProduit' => $faker->randomFloat(2, 10, 100),
                ]
            );
            //dd($produit);
            //fixer l'element de l'entite de coté1:
            $produit->setFournisseur($tousLesfournisseurs[rand(0, count($tousLesfournisseurs) - 1)]);

            $manager->persist($produit);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return ([

            FournisseurFixtures::class
        ]);
    }
}
