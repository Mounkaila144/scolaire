<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;

    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $user = new User();
        $password = $this->hasher->hashPassword($user, '90145781');

        $user->setNom('moubkaila')
            ->setPassword($password)
            ->setPrenom('Boubacar')
            ->setEmail('Admin@gmail.com')
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user->setNom($faker->firstName)
                ->setPassword($password)
                ->setPrenom($faker->lastName)
                ->setEmail($faker->email)
                ->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
        }
    }

    public function getOrder()
    {
        return 1;    }
}