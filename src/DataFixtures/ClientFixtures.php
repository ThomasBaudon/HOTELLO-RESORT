<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
        ){}
        
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($clt = 1; $clt <= 10; $clt++){
            $client = new Client();
            $client->setEmail($faker->email);
            $client->setLastnameClient($faker->lastName);
            $client->setFirstnameClient($faker->firstName);
            $client->setAdressClient($faker->streetAddress);
            $client->setCityClient($faker->city);
            $client->setCountryClient($faker->country);
            $client->setZipClient(str_replace(' ', '',$faker->postcode));
            $client->setPhoneClient($faker->PhoneNumber);
            $client->setBirthdateClient($faker->datetime);
            $client->setRoles(['ROLE_CLIENT']);
            $client->setPassword(
                $this->passwordEncoder->hashPassword($client, 'secret')
            );
            $client->setCreatedAt(new \DateTimeImmutable('now'));
            $manager->persist($client);
            }

            $manager->flush();
    }
}
