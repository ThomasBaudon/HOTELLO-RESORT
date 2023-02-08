<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main',  methods: ['GET'])]
    public function index(UserRepository $userRepository, RoomRepository $roomRepository): Response
    {
        $clients = $userRepository->findAll();
        $rooms = $roomRepository->findAll();
        return $this->render('main/index.html.twig', [
            'clients' => $clients,
            'rooms' => $rooms,
        ]);
    }

    /* SHOW */
    #[Route('/{id}', name: 'app_main_user', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Request $request, int $id, User $user , UserRepository $userRepository): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
