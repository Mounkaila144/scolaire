<?php
namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Fillier;
use App\Repository\FillierRepository;
use App\Repository\PromotionRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EtudiantFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(FillierRepository $fillierRepository)
    {
        $this->fillierRepository = $fillierRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for ($i = 0; $i <= 300; $i++) {
            $fillier = $this->fillierRepository->find($faker->numberBetween(1,6));
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->firstName)
                ->setPrenom($faker->lastName)
                ->setTelephone($faker->phoneNumber)
                ->setFillier($fillier)
                ->setNumero($faker->numberBetween(45,852))
                ->setInscriptionPayer($faker->boolean)
                ->setScolariterPayer($faker->numberBetween(100000,400000));
        $manager->persist($etudiant);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
    }
}
