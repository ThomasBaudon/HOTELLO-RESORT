<?php

namespace App\Controller\Booking;

use App\Entity\Room;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Repository\RoomRepository;
use App\Entity\BookingConfirmation;
use App\Form\BookingConfirmationType;
use App\Repository\BookingRepository;
use App\Repository\EquipmentRepository;
use App\Controller\Search\BookingSearch;
use App\Repository\BookingConfirmationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
#[Route('/booking/show/{id}/{room_title}', name: 'app_booking_show', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
#[Security('is_granted("ROLE_USER")')]

    public function show(
        BookingRepository $bookingRepository,
        EquipmentRepository $equipmentRepository,
        Request $request,
        Room $room,
        RoomRepository $roomRepository,
        User $user,
        ): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }


        /* Get all bookings */
        $bookings = $bookingRepository->findAll();
        $equipments = $equipmentRepository->findAll();
        $session = $request->getSession();
        $total_cost = 0;
        $adults = $session->get('adults', 1);
        $children = $session->get('children', 0);
        $startDate = $session->get('start_date', new DateTimeImmutable());
        $endDate = $session->get('end_date', new DateTimeImmutable());

        if ($startDate > $endDate) {
            $this->addFlash('danger', 'La date de départ doit être supérieure à la date d\'arrivée');
            return $this->redirectToRoute('app_booking');
        }

        // $duration default 1 day if no date selected in booking form 
        $duration = new \DateInterval('P1D');
        if ($startDate && $endDate) {
            $duration = $startDate->diff($endDate);
        }
        // $duration = $startDate->diff($endDate);
        $durationArray = array(
            'days' => $duration->days
        );
        $total_cost = $durationArray['days'] * $room->getPriceRoom();
        $total_cost = $total_cost * 1.02;
        $session->set('totalCost', $total_cost);

        
        
        $bookingConfirm = new BookingConfirmation();
        
        if ($startDate !== null) {
            $bookingConfirm->setStartDate($session->get('start_date', new DateTimeImmutable()));
        }else{
            $bookingConfirm->setStartDate(new DateTimeImmutable('now'));
        }
        if ($endDate !== null) {
            $bookingConfirm->setEndDate($session->get('end_date', new DateTimeImmutable()));
        }else{
            $bookingConfirm->setEndDate(new DateTimeImmutable('now + 1 day'));

        }
        if ($adults !== null) {
            $bookingConfirm->setAdultsCap($session->get('adults', 0));
        }else{
            $bookingConfirm->setAdultsCap(1);
        }
        // $bookingConfirm->setAdultsCap($session->get('adults', 0));
        if ($children !== null) {
            $bookingConfirm->setChildrenCap($session->get('children', 0));
        }else{
            $bookingConfirm->setChildrenCap(0);
        }
        // $bookingConfirm->setChildrenCap($session->get('children', 0));
        $bookingConfirm->setRoom($session->get('room_id', 0));
        if ($total_cost !== null) {
            $bookingConfirm->setTotalCost($session->get('totalCost', 0));
        }
        // $bookingConfirm->setTotalCost($session->get('totalCost', 0));
        $bookingConfirm->setCreatedAt($session->get('created_at', new DateTimeImmutable()));
        $bookingConfirm->setUser($user);
        $bookingConfirm->setRoom($room);
        // dd($bookingConfirm);
        
        
        $bookingConfirmForm = $this->createForm(BookingConfirmationType::class);
        $bookingConfirmForm->handleRequest($request);
        if ($bookingConfirmForm->isSubmitted() && $bookingConfirmForm->isValid()) {
            $bookingConfirm->setCreatedAt(new DateTimeImmutable());
            $this->entityManager->persist($bookingConfirm);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_booking_confirm', ['id' => $user->getId()]);
        }

        return $this->render('booking/show.html.twig', [
            'bookings' => $bookings,
            'rooms' => $roomRepository->findAll(),
            'room' => $room,
            'equipments' => $equipments,
            'user' => $user,
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
