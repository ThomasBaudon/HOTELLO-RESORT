<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Newsletter;
use App\Form\UserFormType;
use App\Form\NewsletterFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    
    #[Route('/client', name: 'app_user')]
    public function index(
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        Request $request
        ): Response
    {
        /* NEWSLETTER PART */
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);
        /* variable envoyée à twig pour vérification */
        $form_submitted = $newsletterForm->isSubmitted();
        /* soumission du formulaire */
        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $newsletter = $newsletterForm->getData();
            $email = $newsletterForm->get('email')->getData();

            /* Vérifie si l'email existe déjà */
            $existingEmail = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['email' => $email]);

            /* Vérifie le statut de la souscription */
            $subscription_status = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['subscription_status' => 1]);
   
            if ($existingEmail)
            {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                // return $this->redirectToRoute('app_main');
            }
            elseif ($subscription_status === 1){
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            }
            else
            {
                $manager->persist($newsletter);
                $manager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');          
                // return $this->redirectToRoute('app_main');
            }

        }

        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }

    /* SHOW */
    #[Route('/client/{id}', name: 'show_user', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(
        int $id,
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        Request $request
        ): Response
    {
         /* NEWSLETTER PART */
         $newsletter = new Newsletter();
         $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
         $newsletterForm->handleRequest($request);
         /* variable envoyée à twig pour vérification */
         $form_submitted = $newsletterForm->isSubmitted();
         /* soumission du formulaire */
         if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
             $newsletter = $newsletterForm->getData();
             $email = $newsletterForm->get('email')->getData();
 
             /* Vérifie si l'email existe déjà */
             $existingEmail = $this->entityManager
                 ->getRepository(Newsletter::class)
                 ->findOneBy(['email' => $email]);
 
             /* Vérifie le statut de la souscription */
             $subscription_status = $this->entityManager
                 ->getRepository(Newsletter::class)
                 ->findOneBy(['subscription_status' => 1]);
    
             if ($existingEmail)
             {
                 $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                 // return $this->redirectToRoute('app_main');
             }
             elseif ($subscription_status === 1){
                 $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
             }
             else
             {
                 $manager->persist($newsletter);
                 $manager->flush();
                 $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');          
                 // return $this->redirectToRoute('app_main');
             }
 
         }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }

    /* EDIT */
    #[Route('/client/edit/{id}', name: 'edit_user', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        int $id,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        ): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        /* NEWSLETTER PART */
        $newsletter = new Newsletter();
        $newsletterForm = $this->createForm(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);
        /* variable envoyée à twig pour vérification */
        $form_submitted = $newsletterForm->isSubmitted();
        /* soumission du formulaire */
        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $newsletter = $newsletterForm->getData();
            $email = $newsletterForm->get('email')->getData();

            /* Vérifie si l'email existe déjà */
            $existingEmail = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['email' => $email]);

            /* Vérifie le statut de la souscription */
            $subscription_status = $this->entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['subscription_status' => 1]);
   
            if ($existingEmail)
            {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                // return $this->redirectToRoute('app_main');
            }
            elseif ($subscription_status === 1){
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            }
            else
            {
                $manager->persist($newsletter);
                $manager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');          
                // return $this->redirectToRoute('app_main');
            }

        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            
                $userRepository->save($user, true);
            
                return $this->redirectToRoute('show_user' , ['id' => $user->getId()]);
            }

        
            
        return $this->render('user/update.html.twig', [
                'UserForm' => $form->createView(),
                'titre' => 'Modifier vos informations personnelles',
                'newsletterForm' => $newsletterForm->createView(),
                'form_submitted' => $form_submitted,
        ]);
    }
}
