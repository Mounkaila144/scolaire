<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class NiveauFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        $niveau = new Niveau();
        $niveau->setAnnee(1)
            ->setScolariter(700000);
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setAnnee(2)
            ->setScolariter(800000);
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setAnnee(3)
            ->setScolariter(900000);
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setAnnee(4)
            ->setScolariter(1000000);
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setAnnee(5)
            ->setScolariter(1200000);
        $manager->persist($niveau);


        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }
}
