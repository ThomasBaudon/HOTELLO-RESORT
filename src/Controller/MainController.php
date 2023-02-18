<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Newsletter;
use App\Form\BookingFormType;
use App\Form\NewsletterFormType;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('', name: 'app_main')]
    public function index(
        UserRepository $userRepository,
        RoomRepository $roomRepository,
        BookingRepository $bookingRepository,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $clients = $userRepository->findAll();
        $rooms = $roomRepository->findAll();

        $booking = new Booking();
        $bookingForm = $this->createForm(BookingFormType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $booking = $bookingForm->getData();
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('app_main');
        }

        /* NEWSLETTER PART */
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
        /* FIN NEWSLETTER PART */

        return $this->render('main/index.html.twig', [
            'clients' => $clients,
            'rooms' => $rooms,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
            'bookingForm' => $bookingForm->createView(),
            
        ]);
    }

    /* SHOW */
    #[Route('/{id}/{lastname_user}-{firstname_user}', name: 'app_main_user', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(
        Request $request,
        int $id,
        User $user,
        EntityManagerInterface $manager
        ): Response
    {
         /* NEWSLETTER PART */
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
         /* FIN NEWSLETTER PART */
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }
}
