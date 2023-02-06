<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ServiceFixtures extends Fixture
{
        
    public function load(ObjectManager $manager): void
    {

        /* SERVICES */
            $petitDej = new Service();
            $petitDej->setNameService('Petit Déjeuner');
            $petitDej->setDescriptionService('Parfois pressé, d’abord énergisant, toujours savoureux : quelle que soit l’envie de petit-déjeuner, l’incontournable préambule aux belles journées se doit d’être à votre rythme, au café-lounge ou en chambre. L’iconique café-croissant parisien sait s’entourer de fraîcheurs salées comme de saveurs sucrées. Au gré des saisons et main dans la main avec des fournisseurs de proximité, le buffet dressé dans le café de l’hôtel Toujours saura tôt ou tard donner envie de tout goûter.');
            $petitDej->setImageService('breakfast.jpg');
            $petitDej->setSlug('service-petit-dejeurner');

            /* Persist */
            $manager->persist($petitDej);


            $barCollations = new Service();
            $barCollations->setNameService('Bar & Collations');
            $barCollations->setDescriptionService('Ici se cultivent les classiques : ces rendez-vous informels, ces pauses essentielles, ces heures-heureuses qui étirent le prétexte d’un verre dans la convivialité d’un café. Au bar de l’hôtel Hotello, les références des cocktails : Negroni, Bellini, Spritz & Gin Tonic… à accompagner en cas de petites faims par des planches salées, pizzas et croque-monsieur sur le pouce.');
            $barCollations->setImageService('bar.jpg');
            $barCollations->setSlug('service-bar-collations');

            /* Persist */
            $manager->persist($barCollations);


            $workSpace = new Service();
            $workSpace->setNameService('Espaces de travail');
            $workSpace->setDescriptionService('Pour les séjours bien affairés, c’est aussi juste en face de l’hôtel Hotello que ça se passe. Au format sur-mesure pour les réunions de travail et les rendez-vous professionnels. Vous n’aurez qu’à traverser le hall pour vous installer dans un bel environnement de travail partagé ou dans votre bureau privatif. Coworking, bureaux privatifs, salles de conférenceÀ partir de 40,00 € la journée. Sur réservation auprès de l’hôtel Hotello');
            $workSpace->setImageService('workspace.jpg');
            $workSpace->setSlug('service-espaces-de-travail');

            /* Persist */
            $manager->persist($workSpace);



        /* FLUSH */
        $manager->flush();
    }
}
