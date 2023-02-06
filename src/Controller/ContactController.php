<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer): Response
        {
            $contact = new Contact();

            $contactForm = $this->createForm(ContactFormType::class, $contact);

            $contactForm->handleRequest($request);
            if ($contactForm->isSubmitted() && $contactForm->isValid()) {
                $contact = $contactForm->getData();

                $manager->persist($contact);
                $manager->flush();

                $email = (new Email())
                    ->from($contact->getEmailContact())
                    ->to('admin@hotello.com')
                    ->subject('Nouveau message de ' . $contact->getFirstnameContact() . ' ' . $contact->getLastnameContact() . ' via le formulaire de contact')
                    ->text($contact->getMessageContact())
                    ->html('<p>Message de :' . $contact->getFirstnameContact() . ' ' . $contact->getLastnameContact() . '</p>' . '<p>Numéro de téléphone : ' . $contact->getPhoneContact() . '</p>' . '<p>Adresse email : ' . $contact->getEmailContact() . '</p>' . '<p>Envoyé le ' . $contact->getCreatedAt()->format('d/m/Y à H:i:s') . '</p>'.'<p>Message : ' . $contact->getMessageContact() . '</p>');

                $mailer->send($email);                

                // dd($mailer);
                return $this->redirectToRoute('app_sent');
            }


            return $this->render('contact/index.html.twig', [
                'contactForm' => $contactForm->createView(),
            ]);
        }

    #[Route('/sent', name: 'app_sent')]
    public function sent(): Response
    {
        return $this->render('contact/sent.html.twig');
    }

}
