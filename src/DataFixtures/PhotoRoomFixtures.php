<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\PhotoRoom;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTimeImmutable;

class PhotoRoomFixtures extends Fixture
{
    

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1412);


        /* PhotoRooms */
        for($photo = 1; $photo <= 10; $photo++){
            $photoRoom = new PhotoRoom();
            $photoRoom->setPathPhoto($faker->imageUrl(640, 480, 'cats'));
            $photoRoom->setUpdatedAt(new DateTimeImmutable('now'));
            $photoRoom->setCreatedAt(new DateTimeImmutable('now'));

            /* Persist */
            $manager->persist($photoRoom);
        }

        /* FLUSH */
        $manager->flush();
    }
}
