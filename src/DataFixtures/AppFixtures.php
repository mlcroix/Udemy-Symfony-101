<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher, 
        private EntityManagerInterface $entityManager) 
    { 
        
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail("meepmoop@gmail.com");
        $user1->setPassword($this->passwordHasher->hashPassword($user1, "password"));
        $user1->setRoles(["ROLE_USER"]);
        $manager->persist($user1);  

        $user2 = new User();
        $user2->setEmail("johndoe@gmail.com");
        $user2->setPassword($this->passwordHasher->hashPassword($user2, "password"));
        $user2->setRoles(["ROLE_USER"]);
        $manager->persist($user2);
        


        $microPost1 = new MicroPost();
        $microPost1->setTitle("Welcome to Poland");
        $microPost1->setText("meep moop");
        $microPost1->setCreated(new DateTime());

        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle("Welcome to Germany");
        $microPost2->setText("meep moop");
        $microPost2->setCreated(new DateTime());

        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle("Welcome to Poland");
        $microPost3->setText("meep moop");
        $microPost3->setCreated(new DateTime());

        $manager->persist($microPost3);


        $manager->flush();
    }
}
