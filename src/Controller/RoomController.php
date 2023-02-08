<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use App\Repository\RoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    #[Route('/chambres', name: 'app_room')]


    public function index(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
            'rooms' => $rooms,
        ]);
    }

    #[Route('/chambres/{id}', name: 'app_room_show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Request $request, int $id, RoomRepository $roomRepository, EquipmentRepository $equipmentRepository ): Response
    {
        $room = $roomRepository->find($id);
        $equipments = $room->getEquipment();
        $photoRooms = $room->getPhotoRoom();
        return $this->render('room/show.html.twig', [
            'room' => $room,
            'equipments' => $equipments,
            'photoRooms' => $photoRooms,
        ]);
    }

}
