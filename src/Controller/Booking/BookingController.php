<?php

namespace App\Controller\Booking;

use App\Entity\Room;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Trait\IsAvailableTrait;
use App\Repository\EquipmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    use IsAvailableTrait;

    #[Route('/booking', name: 'app_booking')]
    public function index(
        UserRepository $userRepository,
        RoomRepository $roomRepository,
        Request $request,
        EntityManagerInterface $manager
    ): Response
    {



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


        /* Check Availability */
        function checkAvailability(Request $request, EntityManagerInterface $entityManager, int $roomId, string $startDate, string $endDate)
        {
            $room = $entityManager->getRepository(Room::class)->find($roomId);
            $bookings = $entityManager->getRepository(Booking::class)->findBy([
                'room' => $room,
                'start_date' => [$startDate, $endDate],
                'end_date' => [$startDate, $endDate]
            ]);
            
            if (count($bookings) > 0) {
                return new Response('La chambre n\'est pas disponible pour cette période');
            }
            return new Response('La chambre est disponible pour cette période');
        }
        /* END Check Availability */

        return $this->render('booking/index.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'rooms' => $roomRepository->findAll(),
        ]);
    }


    #[Route('/booking/{id}', name: 'app_booking_show', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function show(
        Booking $booking,
        int $id,
        Room $room,
        UserRepository $userRepository,
        RoomRepository $roomRepository,
        Request $request,
        EntityManagerInterface $manager,
        EquipmentRepository $equipmentRepository
    ): Response
    {

        /* END Booking Form */
        $equipments = $equipmentRepository->findAll();
        $clients = $userRepository->findAll();
        $rooms = $roomRepository->findAll();

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
            'booking' => $booking->getId(),
            'bookingForm' => $bookingForm->createView(),
            'rooms' => $roomRepository->findAll(),
            'room' => $room,
            'equipments' => $equipments,
        ]);
    }



}
