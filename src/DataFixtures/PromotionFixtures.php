<?php

namespace App\DataFixtures;

use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class PromotionFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        $promotion = new Promotion();
        $promotion->setAnnee(new \DateTime("2022-01-01"));
        $manager->persist($promotion);
         $promotion = new Promotion();
        $promotion->setAnnee(new \DateTime("2023-01-01"));
        $manager->persist($promotion);
         $promotion = new Promotion();
        $promotion->setAnnee(new \DateTime("2024-01-01"));
        $manager->persist($promotion);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }
}
