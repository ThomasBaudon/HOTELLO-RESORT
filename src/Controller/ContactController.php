<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact',  methods: ['GET', 'POST'])]
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactFormType::class, $contact);
        $contactForm->handleRequest($request);


        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $contactRepository->save($contact, true);
            
            return $this->redirectToRoute('app_main');
        }


        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }

}
