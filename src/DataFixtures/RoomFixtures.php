<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RoomFixtures extends Fixture
{
        
    public function load(ObjectManager $manager): void
    {

        /* ROOMS */
            $montaigne = new Room();
            $montaigne->setTitleRoom('Montaigne');
            $montaigne->setPriceRoom(499);
            $montaigne->setTypeRoom('Chambre double');
            $montaigne->setSizeRoom(25);
            $montaigne->setDescriptionRoom('La sobriété d’une palette naturelle, la tactilité tout en subtilité : en apparente simplicité, le lin effleure le chic décontracté. Aussi aisée à vivre qu’une belle chemise à enfiler, cette chambre classique a l’étoffe de l’élégance et une praticité de belle prestance.');
            $montaigne->setAdultsCap(2);
            $montaigne->setChildrenCap(1);
            $montaigne->setStatusRoom(false);
            $montaigne->setSlug('chambre-double-montaigne');

            /* Persist */
            $manager->persist($montaigne);


            $rivoli = new Room();
            $rivoli->setTitleRoom('Rivoli');
            $rivoli->setPriceRoom(699);
            $rivoli->setTypeRoom('Chambre double');
            $rivoli->setSizeRoom(35);
            $rivoli->setDescriptionRoom('Grand classique aussi masculin que féminin, le trench instille ici son allure pleine d’aisance. Lignes structurées, beige mastic gansé de vert grisé et incontournable motif tartan : ces discrètes réminiscences inspirent le confort tout en assurance. Le choix d’un style intemporel et affirmé.');
            $rivoli->setAdultsCap(2);
            $rivoli->setChildrenCap(1);
            $rivoli->setStatusRoom(false);
            $rivoli->setSlug('chambre-double-rivoli');

            /* Persist */
            $manager->persist($rivoli);


            $montorgueil = new Room();
            $montorgueil->setTitleRoom('Montorgueil');
            $montorgueil->setPriceRoom(1499);
            $montorgueil->setTypeRoom('Suite familial');
            $montorgueil->setSizeRoom(45);
            $montorgueil->setDescriptionRoom('Évoquant les nuances de la cape d’un cigare, les effets cuir et bois de cette chambre s’influencent des notes chères aux amatrices et amateurs de belles vitoles, partagas et autres panatellas. Une chaleureuse tranquillité qui invite à prendre un peu de lenteur et à humer l’air… du temps. Appelant les gestes sereins et raffinés, l’ampleur de ces chambres sera du goût des initiés.');
            $montorgueil->setAdultsCap(2);
            $montorgueil->setChildrenCap(2);
            $montorgueil->setStatusRoom(false);
            $montorgueil->setSlug('suite-familial-montorgueil');

            /* Persist */
            $manager->persist($montorgueil);

        /* FLUSH */
        $manager->flush();
    }
}
