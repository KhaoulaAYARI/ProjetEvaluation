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
            ]
        );
        $manager->persist($fournisseur);

        } 

        $manager->flush();
    }
}
