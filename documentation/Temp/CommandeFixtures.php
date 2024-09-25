<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Fournisseur;
use App\Entity\DetailCommande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class CommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rep=$manager->getRepository(Commande::class);
        

        $faker=Factory::create("fr_BE");

        for($i=1; $i<50; $i++){
        $commande = new Commande(
            [
                'numero'=>rand(10,60),
                'dateCommande'=>$faker->dateTimeBetween('-1 year', 'now'),
                'statutCommande'=>$faker->randomElement(['en cours', 'termine']),
            ]
        );
        
        
        $manager->persist($commande);

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
