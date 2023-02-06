<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Contact;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1412);


        /* Contacts */
        for($ctct = 1; $ctct <= 10; $ctct++){
            $contact = new Contact();
            $contact->setEmailContact($faker->email);
            $contact->setLastnameContact($faker->lastName);
            $contact->setFirstnameContact($faker->firstName);
            $contact->setPhoneContact(str_replace(' ', '',$faker->PhoneNumber));
            $contact->setMessageContact($faker->text);
            $contact->setCreatedAt(new \DateTimeImmutable('now'));

            /* Persist */
            $manager->persist($contact);
        }

        /* FLUSH */
        $manager->flush();
    }
}
