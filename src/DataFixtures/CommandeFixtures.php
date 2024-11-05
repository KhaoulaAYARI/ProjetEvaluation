<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //obtenier tous les elements de coté1
        $rep=$manager->getRepository(Fournisseur::class);
        $tousLesfournisseurs=$rep->findAll();
        $faker=Factory::create("fr_BE");

        for($i=0; $i<100; $i++){
        $commande = new Commande(
            [
                'numero'=>$i + 1000,
                
                'dateCommande'=>$faker->dateTimeBetween('-1 year', 'now'),
                'statutCommande'=>$faker->randomElement(['en cours', 'termine']),
            ]
        );

        //fixer l'element de l'entite de coté1:
        $commande->setCommandeFournisseur($tousLesfournisseurs[rand(0, count($tousLesfournisseurs)-1)]);
        $manager->persist($commande);

        } 

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            FournisseurFixtures::class,
        ];
    }
}
