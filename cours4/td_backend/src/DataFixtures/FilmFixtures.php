<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Realisator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FilmFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $realisator = [];
        for ($i = 0; $i < 10; $i++) {
            $real = new Realisator();
            $real->setName($faker->name());
            $manager->persist($real);
            $realisator[] = $real;
        }

        for ($i = 0; $i < 20; $i++) {
            $film = new Film();
            $film->setTitle($faker->sentence(3));
            $film->setYear($faker->numberBetween(1900, 2023));
            $film->setRealisators($realisator[array_rand($realisator)]);
            $manager->persist($film);
        }

        $manager->flush();
    }
}
