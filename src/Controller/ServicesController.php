<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterFormType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/services', name: 'app_services')]
    public function index(
        ServiceRepository $serviceRepository,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $services = $serviceRepository->findAll();

        /* NEWSLETTER */
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
        /* FIN NEWSLETTER */
        return $this->render('services/index.html.twig',[
            'services' => $services,
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }
}
