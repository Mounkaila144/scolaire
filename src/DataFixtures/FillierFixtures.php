<?php
namespace App\DataFixtures;

use App\Entity\Fillier;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class FillierFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");


        $fillier = new Fillier();
        $fillier->setNom("L1 Rh")
                ->setNiveau(1)
                ->setScolariterApayer(700000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L2 Rh")
                ->setNiveau(2)
                ->setScolariterApayer(800000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L3 Rh")
                ->setNiveau(3)
                ->setScolariterApayer(900000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L1 imformatique")
                ->setNiveau(1)
                ->setScolariterApayer(700000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L2 imformatique")
                ->setNiveau(2)
                ->setScolariterApayer(800000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L3 imformatique")
                ->setNiveau(3)
                ->setScolariterApayer(900000);
        $manager->persist($fillier);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}
