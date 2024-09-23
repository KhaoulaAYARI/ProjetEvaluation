<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher=$passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<5; $i++){
        $user = new User();
        $user->setEmail("user" . $i . "@gmail.com");
        $user->setRoles(['ROLE_USER']);
        //on cree un password hashé
        $hashedPassword=$this->passwordHasher->hashPassword($user, 'lepassword');
        $user->setNom("nom" . $i);
        $user->setMatricule("matricule" . $i);

        $user->setPassword($hashedPassword);

        $manager->persist($user);
        }
        for($i=5; $i<10; $i++){
            $user = new User();
            $user->setEmail("admin" . $i . "@gmail.com");
            $user->setRoles(['ROLE_ADMIN']);
            $hashedPassword=$this->passwordHasher->hashPassword($user, 'lepassword');
            $user->setNom("nom" . $i);
            $user->setMatricule("matricule" . $i);
            $user->setPassword($hashedPassword);
    
            $manager->persist($user);
            }

        $manager->flush();
    }
}
