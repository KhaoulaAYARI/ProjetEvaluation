<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //obtenier ts les elts de l'entité de coté1: 
        $rep=$manager->getRepository(Produit::class);
        $tousLesProduits=$rep->findAll();

        $faker=Factory::create("fr_BE");

        for($i=0; $i<100; $i++){
        $produit = new produit(
            [
                'matricule'=>$faker->ean8(),
                'description'=>$faker->sentence(3),
                'prix'=>$faker->randomFloat(2,10,100),
            ]
        );
        //fixer l'element de l'entite de coté1:
        $produit->setFournisseur($tousLesProduits[rand(0,count($tousLesProduits)-1)]);
        
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
