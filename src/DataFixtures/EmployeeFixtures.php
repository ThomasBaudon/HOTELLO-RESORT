<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Employee;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EmployeeFixtures extends Fixture
{
        
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1412);

        /* EMPLOYEES */
        for($empl = 1; $empl <= 10; $empl++){
            $employee = new Employee();
            $employee->setLastnameEmployee($faker->lastName);
            $employee->setFirstnameEmployee($faker->firstName);
            $employee->setJobEmployee($faker->streetAddress);
            $employee->setJobEmployee($faker->jobTitle);
            $employee->setPhotoEmployee($faker->imageUrl(640, 480, 'people', true, 'Faker', true));
            $employee->setArrivalDate($faker->dateTime);

            /* Persist */
            $manager->persist($employee);
        }

        /* FLUSH */
        $manager->flush();
    }
}
