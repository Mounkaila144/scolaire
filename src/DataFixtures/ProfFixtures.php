<?php

namespace App\DataFixtures;


use App\Entity\Prof;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ProfFixtures extends Fixture implements OrderedFixtureInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;

    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $user = new Prof();
        $password = $this->hasher->hashPassword($user, '90145781');
        $user->setNom('moubkaila')
            ->setPassword($password)
            ->setPrenom('Boubacar')
            ->setEmail('Prof1@gmail.com')
            ->setRoles(['ROLE_PROF']);
        $manager->persist($user);

        $user->setNom('moubkaila')
            ->setPassword($password)
            ->setPrenom('Boubacar')
            ->setEmail('Prof2@gmail.com')
            ->setRoles(['ROLE_PROF']);
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;    }
}