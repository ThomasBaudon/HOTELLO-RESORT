<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterFormType;
use App\Repository\RoomRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class RoomController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/chambres', name: 'app_room')]
    public function index(
        RoomRepository $roomRepository,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $rooms = $roomRepository->findAll();

        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        /* variable envoyée à twig pour vérification */
        $form_submitted = $newsletterForm->isSubmitted();

        /* soumission du formulaire */
        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $newsletter = $newsletterForm->getData();
            $email = $newsletterForm->get('email')->getData();

            /* Vérifie si l'email existe déjà */
            $existingEmail = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['email' => $email]);

            /* Vérifie le statut de la souscription */
            $subscription_status = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['subscription_status' => 1]);
   
            if ($existingEmail)
            {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                // return $this->redirectToRoute('app_main');
            }
            elseif ($subscription_status === 1){
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            }
            else
            {
                $manager->persist($newsletter);
                $manager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');          
                // return $this->redirectToRoute('app_main');
            }

        }

        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
            'rooms' => $rooms,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }

    #[Route('/chambres/{id}', name: 'app_room_show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(
        Request $request,
        int $id,
        RoomRepository $roomRepository,
        EquipmentRepository $equipmentRepository,
        EntityManagerInterface $manager
        ): Response
    {
        $room = $roomRepository->find($id);
        $equipments = $room->getEquipment();
        $photoRooms = $room->getPhotoRoom()->slice(0, 3);

        /* NEWSLETTER */
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        /* variable envoyée à twig pour vérification */
        $form_submitted = $newsletterForm->isSubmitted();

        /* soumission du formulaire */
        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $newsletter = $newsletterForm->getData();
            $email = $newsletterForm->get('email')->getData();

            /* Vérifie si l'email existe déjà */
            $existingEmail = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['email' => $email]);

            /* Vérifie le statut de la souscription */
            $subscription_status = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['subscription_status' => 1]);
   
            if ($existingEmail)
            {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                // return $this->redirectToRoute('app_main');
            }
            elseif ($subscription_status === 1){
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            }
            else
            {
                $manager->persist($newsletter);
                $manager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');          
                // return $this->redirectToRoute('app_main');
            }

        }
        /* FIN NEWSLETTER */

        return $this->render('room/show.html.twig', [
            'room' => $room,
            'equipments' => $equipments,
            'photoRooms' => $photoRooms,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }

}
