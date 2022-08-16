<?php
namespace App\DataFixtures;

use App\Entity\Fillier;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class FillierFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        $pro="2022";
        $year=new \DateTime("$pro-01-01");
        $promo=$this->promotionRepository->findOneBy(["annee"=>$year]);
        $fillier = new Fillier();
        $fillier->setNom("L1 Rh")
                ->setNiveau(1)
                ->setPromotion($promo)
                ->setScolariterApayer(700000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L2 Rh")
                ->setNiveau(2)
                ->setPromotion($promo)
                ->setScolariterApayer(800000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L3 Rh")
                ->setNiveau(3)
                ->setPromotion($promo)
                ->setScolariterApayer(900000);
        $manager->persist($fillier);

        $pro="2022";
        $year=new \DateTime("$pro-01-01");
        $promo=$this->promotionRepository->findOneBy(["annee"=>$year]);
        $fillier = new Fillier();
        $fillier->setNom("L1 imformatique")
                ->setNiveau(1)
                ->setPromotion($promo)
                ->setScolariterApayer(700000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L2 imformatique")
                ->setNiveau(2)
                ->setPromotion($promo)
                ->setScolariterApayer(800000);
        $manager->persist($fillier);


        $fillier = new Fillier();
        $fillier->setNom("L3 imformatique")
                ->setNiveau(3)
                ->setPromotion($promo)
                ->setScolariterApayer(900000);
        $manager->persist($fillier);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}
