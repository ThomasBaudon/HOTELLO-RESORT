<?php

namespace App\Controller\Booking;

use App\Entity\Room;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Controller\Search\BookingSearch;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EquipmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class BookingController extends AbstractController
{

    private $entityManager;
    private $bookingSearch;

    
    public function __construct(
        EntityManagerInterface $entityManager,
        BookingSearch $bookingSearch,
        )
        {
            $this->entityManager = $entityManager;
            $this->bookingSearch = $bookingSearch;
        }
        
    
    /* ROUTE BOOKING ACCUEIL */
    #[Route('/booking', name: 'app_booking')]
    public function index(
        BookingRepository $bookingRepository,
        Request $request,
        RoomRepository $roomRepository,
        ): Response
    {
        /* Get all rooms */
        $rooms = $roomRepository->findAll();
        /* Booking Form */
        $booking = new Booking();
        $bookingForm = $this->createForm(BookingFormType::class, $booking);
        $bookingForm->handleRequest($request);
        /* END Booking Form */
        
        $bookings = $bookingRepository->filters($booking);
        // Renvoie les informations sous forme de tableau
        // dd($booking);
        
    /* ------------------------------------------------------------------------------------------------ */
    /* RETURNS ON FRONT */
        return $this->render('booking/index.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'rooms' => $rooms,
            'bookings' => $bookings,
            'booking' => $booking,
        ]);
    }





/* ROUTE BOOKING DÉTAIL CHAMBRE CHOISIE */
#[Route('/booking/show/{id}', name: 'app_booking_show', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function show(
        BookingRepository $bookingRepository,
        EquipmentRepository $equipmentRepository,
        EntityManagerInterface $manager,
        Request $request,
        Room $room,
        RoomRepository $roomRepository,
        ): Response
    {

        // Récupération des dates stockées dans les sessions pour les afficher dans le formulaire
        $start_date = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : '';
        $end_date = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : '';

        /* Get all bookings */
        $bookings = $bookingRepository->findAll();
        $equipments = $equipmentRepository->findAll();

        /* Booking Form */
        $booking = new Booking();
        $bookingForm = $this->createForm(BookingFormType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $booking = $bookingForm->getData();
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('app_booking');
        }
        /* END Booking Form */

        

        return $this->render('booking/show.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'bookings' => $bookings,
            'rooms' => $roomRepository->findAll(),
            'room' => $room,
            'equipments' => $equipments,
        ]);
    }



}
