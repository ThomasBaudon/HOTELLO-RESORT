<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Form\NewsletterFormType;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Trait\NewsletterTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    use NewsletterTrait;
    
    private $entityManager;
    private $newsletterForm;
    private $form_submitted;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_main')]
    public function index(
    UserRepository $userRepository,
    RoomRepository $roomRepository,
    Request $request,
    EntityManagerInterface $manager,
    FormFactoryInterface $formFactory,
    EntityManagerInterface $entityManager,
    NewsletterRepository $newsletterRepository,
    ): Response
    {
        $clients = $userRepository->findAll();
        $rooms = $roomRepository->findAll();
        $this->handleNewsletterSubscription($request, $formFactory, $entityManager, $newsletterRepository);
        $newsletterForm = $this->newsletterForm;
        $form_submitted = $this->form_submitted;
        $this->addFlash('type', 'message');

        $booking = new Booking();
        $bookingForm = $this->createForm(BookingFormType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $booking = $bookingForm->getData();
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/index.html.twig', [
            'clients' => $clients,
            'rooms' => $rooms,
            'bookingForm' => $bookingForm->createView(),
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
            
        ]);
    }

    /* SHOW */
    #[Route('/{id}', name: 'app_main_user', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(
        Request $request, User $user,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        NewsletterRepository $newsletterRepository
        ): Response
    {

        $this->handleNewsletterSubscription($request, $formFactory, $entityManager, $newsletterRepository);
        $newsletterForm = $this->newsletterForm;
        $form_submitted = $this->form_submitted;

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }
}
