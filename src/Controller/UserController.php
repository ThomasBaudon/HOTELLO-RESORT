<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/client', name: 'app_user')]

    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    /* SHOW */
    #[Route('/client/{id}', name: 'show_user', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Request $request, int $id, User $user , UserRepository $userRepository): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /* EDIT */
    #[Route('/client/edit/{id}', name: 'edit_user', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, int $id, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
                $userRepository->save($user, true);
            
                return $this->redirectToRoute('show_user/{id}' , ['id' => $user->getId()]);
            }
            
        return $this->render('user/update.html.twig', [
                'UserForm' => $form->createView(),
                'titre' => 'Modifier vos informations personnelles',
        ]);
    }
}
