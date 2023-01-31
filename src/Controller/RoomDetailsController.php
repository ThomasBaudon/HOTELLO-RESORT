<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomDetailsController extends AbstractController
{
    #[Route('/chambres/detail', name: 'app_room_detail')]
    public function index(): Response
    {
        return $this->render('room_details/index.html.twig');
    }
}
