<?php

namespace App\Controller\Booking;

use App\Entity\Room;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Controller\Search\BookingSearch;
use App\Entity\BookingConfirmation;
use App\Entity\User;
use App\Form\BookingConfirmationType;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping\Id;
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
        // Renvoie les informations sous forme d’objet
        // dd($booking);
        $session = $request->getSession();
        $session->set('start_date', $booking->getStartDate());
        $session->set('end_date', $booking->getEndDate());
        $session->set('room_id', $booking->getRoom());
        $session->set('adults', $booking->getAdultsCap());
        $session->set('children', $booking->getChildrenCap());
        $session->set('totalCost', $booking->getTotalCost());
        $session->set('booking_status', $booking->isBookingStatus());
        $session->set('user_id', $booking->getUser());
        $session->set('created_at', $booking->getCreatedAt());
        $session->set('updated_at', $booking->getUpdatedAt());
        $session->set('booking_id', $booking->getId());
        $session->set('room_id', $booking->getRoom());
        // dd($session);
        
    /* ------------------------------------------------------------------------------------------------ */
    /* RETURNS ON FRONT */
        return $this->render('booking/index.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'rooms' => $rooms,
            'bookings' => $bookings,
            'booking' => $booking,
            'session' => $session,
        ]);
    }





/* ROUTE BOOKING DÉTAIL CHAMBRE CHOISIE */
#[Route('/booking/show/{id}', name: 'app_booking_show', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]

    public function show(
        BookingRepository $bookingRepository,
        BookingConfirmationType $bookingConfirmation,
        EquipmentRepository $equipmentRepository,
        Request $request,
        Room $room,
        User $user,
        RoomRepository $roomRepository,
        ): Response
    {




        /* Get all bookings */
        $bookings = $bookingRepository->findAll();
        $equipments = $equipmentRepository->findAll();

        $session = $request->getSession();
        $start_date = $session->get('start_date');
        $end_date = $session->get('end_date');
        $adults = $session->get('adults');
        $children = $session->get('children');
        $duration = $end_date->diff($start_date)->days;
        $room_id = $session->get('room_id');
        // dd($session);

        $roomData = ['room_id' => $room->getId()];
        //convert in string $roomData
        // $roomData = strval($roomData);
        // dd($roomData);
        $bookingConfirm = new BookingConfirmation();
        $bookingConfirmForm = $this->createForm(BookingConfirmationType::class, $bookingConfirm, ['data' => $roomData]);
        $bookingConfirmForm->handleRequest($request);
        if ($bookingConfirmForm->isSubmitted() && $bookingConfirmForm->isValid()) {
            $this->entityManager->persist($bookingConfirm);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_booking_confirm', ['id' => $user->getId()]);
        }

        return $this->render('booking/show.html.twig', [
            'bookings' => $bookings,
            'rooms' => $roomRepository->findAll(),
            'room' => $room,
            'equipments' => $equipments,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'adults' => $adults,
            'children' => $children,
            'duration' => $duration,
            'user' => $user,
            'room_id' => $room_id,
            'session' => $session,
            'bookingConfirmForm' => $bookingConfirmForm->createView(),
        ]);
    }


    /* ROUTE BOOKING CONFIRMATION */
    #[Route('/booking/confirm/{id}', name: 'app_booking_confirm', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]

    public function confirm(): Response
    {

       return $this->render('booking/confirm.html.twig');
    }





}
