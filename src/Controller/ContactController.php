<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Newsletter;
use App\Form\ContactFormType;
use App\Form\NewsletterFormType;
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
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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


            return $this->render('contact/index.html.twig', [
                'contactForm' => $contactForm->createView(),
                'newsletterForm' => $newsletterForm->createView(),
                'form_submitted' => $form_submitted,
            ]);
        }

    #[Route('/sent', name: 'app_sent')]
    public function sent(Request $request, EntityManagerInterface $manager): Response
    {

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
        return $this->render('contact/sent.html.twig',
        [
            'newsletterForm' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ]);
    }

}
