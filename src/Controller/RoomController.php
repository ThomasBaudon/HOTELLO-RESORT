<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/chambres', name: 'app_room')]
    public function index(): Response
    {
        return $this->render('room/index.html.twig');
    }
}
