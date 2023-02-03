<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
        ){}
        
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        /* ADMIN */
        $admin = new User();
        $admin->setEmail('thomas@thomasbaudon.fr');
        $admin->setFirstnameUser('Thomas');
        $admin->setLastnameUser('Baudon');
        $admin->setAdressUser('140 rue Pierre Fichu');
        $admin->setZipUser('60190');
        $admin->setCityUser('Moyvillers');
        $admin->setCountryUser('France');
        $admin->setPhoneUser('0676844497');
        $admin->setBirthdateUser(new \DateTimeImmutable('1983-05-30'));
        $admin->setRoles(['ROLE_ADMIN'], ['ROLE_USER']);
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, '1412Taitaz-64@')
        );
        $admin->setCreatedAt(new \DateTimeImmutable('now'));
        $manager->persist($admin);


        /* USERS */
        for($usr = 1; $usr <= 10; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastnameUser($faker->lastName);
            $user->setFirstnameUser($faker->firstName);
            $user->setAdressUser($faker->streetAddress);
            $user->setCityUser($faker->city);
            $user->setCountryUser($faker->country);
            $user->setZipUser(str_replace(' ', '',$faker->postcode));
            $user->setPhoneUser(str_replace(' ', '',$faker->PhoneNumber));
            $user->setBirthdateUser($faker->datetime);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $manager->persist($user);
        }

        /* FLUSH */
        $manager->flush();
    }
}
