<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FournisseurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create("fr_BE");

        for($i=0; $i<25; $i++){
        $fournisseur = new Fournisseur(
            [
                'nom'=>$faker->company(),
                'adresse'=>$faker->address(),
                'email'=>$faker->email(),
                'taille'=>$faker->randomElement(['Petite', 'Moyenne', 'Grande']),
                'localisationGeographique'=>$faker->randomElement(['Nationale', 'internationale', 'local']),  
                'prix'=>$faker->randomElement(['Fixe', 'Negociable', 'Variable']),  
                'certifications'=>$faker->randomElement(['ISO 9001', 'ISO 45001', 'ISO 14001']), 
                'technologiesUtilisees'=>$faker->randomElement(['Avancée', 'Intermediaire', 'Basique']),
                 'modesDeLivraison'=>$faker->randomElement(['Camion', 'bateau','avion','train', 'autre']),                                                                                                                   
            ]
        );
        $manager->persist($fournisseur);

        } 

        $manager->flush();
    }
}
