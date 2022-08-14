<?php
namespace App\DataFixtures;

use App\Entity\Fillier;
use App\Repository\NiveauRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class FillierFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(NiveauRepository $niveauRepository)
    {
        $this->niveauRepository = $niveauRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        $niveau=$this->niveauRepository->find(1);
        $fillier = new Fillier();
        $fillier->setNom("L1 Rh")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $niveau=$this->niveauRepository->find(2);
        $fillier = new Fillier();
        $fillier->setNom("L1 Rh")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $niveau=$this->niveauRepository->find(3);
        $fillier = new Fillier();
        $fillier->setNom("L1 Rh")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $niveau=$this->niveauRepository->find(1);
        $fillier = new Fillier();
        $fillier->setNom("L1 imformatique")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $niveau=$this->niveauRepository->find(2);
        $fillier = new Fillier();
        $fillier->setNom("L1 imformatique")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $niveau=$this->niveauRepository->find(3);
        $fillier = new Fillier();
        $fillier->setNom("L1 imformatique")
                ->setNiveau($niveau);
        $manager->persist($fillier);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}
