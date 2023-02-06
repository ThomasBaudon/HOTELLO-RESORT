<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Equipment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EquipmentFixtures extends Fixture
{
        
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1412);

        /* EQUIPMENTS */
        for($eqp = 1; $eqp <= 10; $eqp++){
            $equipment = new Equipment();
            $equipment->setIcon($faker->imageUrl(100, 100));
            $equipment->setName($faker->word);
            $equipment->setDescriptionEquipment($faker->text);

            /* Persist */
            $manager->persist($equipment);
        }

        /* FLUSH */
        $manager->flush();
    }
}
