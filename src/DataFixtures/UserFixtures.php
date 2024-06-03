<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        // création d'un admin
         $adminUser = new User();
        $adminUser->setLastname($faker->lastName())
            ->setFirstname($faker->firstName())
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@otv.com');
        $password = $this->passwordHasher->hashPassword($adminUser, 'password');
        $adminUser->setPassword($password);
        $manager->persist($adminUser);

        // création d'utilisateurs 
     /*  for ($i = 0; $i < 5; $i++) {
            $users = new User();
            $users->setLastname($faker->lastName())
                    ->setFirstname($faker->firstName())
                    ->setRoles(['ROLE_USER'])
                    ->setEmail($faker->email());
            $manager->persist($users);

            $password = $this->passwordHasher->hashPassword($users, $faker->word());
            $users->setPassword($password);
        }      */

        // enregistrement en BDD
        $manager->flush();
    }
}
