<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use App\Entity\DetailCommande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class DetailCommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rep=$manager->getRepository(DetailCommande::class);
        

        $faker=Factory::create("fr_BE");

        for($i=1; $i<50; $i++){
        $detailCommande = new DetailCommande(
            [
                'quantite'=>random_int(5,20),
                'prixUnitaire'=>$faker->randomFloat(2,10,100),
            ]
        );
        
        
        $manager->persist($detailCommande);

        } 

        $manager->flush();
    }
    
    public function getDependencies()
    {
        return ([
            CommandeFixtures::class, 
            ProduitFixtures::class
        ]);
    }
}
