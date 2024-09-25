<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //obtenier tous les elements de coté1
        $rep=$manager->getRepository(Fournisseur::class);
        $tousLesfournisseurs=$rep->findAll();
        $faker=Factory::create("fr_BE");

        for($i=0; $i<50; $i++){
        $produit = new Produit(
            [
                'matricule'=>$faker->ean8(),
                'description'=>$faker->sentence(3),
                'prix'=>$faker->randomFloat(2, 10, 100),
            ]
        );

        //fixer l'element de l'entite de coté1:
        $produit->setProduitFournisseur($tousLesfournisseurs[rand(0, count($tousLesfournisseurs)-1)]);
        $manager->persist($produit);

        } 

        $manager->flush();
    }
}
