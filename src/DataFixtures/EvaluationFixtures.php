<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Evaluation;
use App\Entity\Fournisseur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EvaluationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //obtenier tous les elements de coté1 "Fournisseur"
        $rep=$manager->getRepository(Fournisseur::class);
        $tousLesfournisseurs=$rep->findAll();
        //obtenier tous les elements de coté1 "User"
        $rep=$manager->getRepository(User::class);
        $tousLesUser=$rep->findAll();


        $faker=Factory::create("fr_BE");

        for($i=0; $i<50; $i++){
        $evaluation = new Evaluation(
            [
                'note'=>$faker->randomElement([1,2,3,4,5]),
                'commentaire'=>$faker->sentence(5),
                'date'=>$faker->dateTimeBetween('-1 year', 'now'),
                'systemeManagementQualite'=>$faker->randomElement(['Non-conforme','Implementé','Conforme','Excellent']),
                'respectCriteresQualite'=>$faker->randomElement(['Respecté','Non-respecté']),
                'respectSpecificationsProduit'=>$faker->randomElement(['Respecté','Non-respecté']),
                'aspectGeneraleProcessusFabrication'=>$faker->randomElement(['Non-conforme','Conforme','Excellent']),

            ]
        );

        //fixer l'element de l'entite de coté1 "Fournisseur"
        $evaluation->setEvaluationFournisseur($tousLesfournisseurs[rand(0, count($tousLesfournisseurs)-1)]);
        //fixer l'element de l'entite de coté1 "User"
        $evaluation->setUser($tousLesUser[rand(0, count($tousLesUser)-1)]);
        $manager->persist($evaluation);

        } 

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FournisseurFixtures::class,
            UserFixtures::class,
        ];
    }
}
