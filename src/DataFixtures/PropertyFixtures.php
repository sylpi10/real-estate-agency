<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_EN');
        for ($i = 0; $i < 100; $i++) {

            $property = new Property();
            $property->setTitle($faker->words(3, true))
                ->setPrice($faker->numberBetween(20000, 840000))
                ->setRooms($faker->numberBetween(2, 8))
                ->setSurface($faker->numberBetween(20, 340))
                ->setBedrooms($faker->numberBetween(1, 5))
                ->setCity($faker->city)
                ->setPostalCode($faker->postcode)
                ->setDescription($faker->sentences(3, true))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setAddress($faker->address);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
