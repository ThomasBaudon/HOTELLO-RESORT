<?php

namespace App\Controller\Trait;

use App\Entity\Newsletter;
use App\Form\NewsletterFormType;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

trait NewsletterTrait
{
    private function handleNewsletterSubscription(
        Request $request,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        NewsletterRepository $newsletterRepository
    ) {
        $newsletter = new Newsletter();
        $newsletterForm = $formFactory->create(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $email = $newsletterForm->getData()->getEmail();
            $existingEmail = $newsletterRepository->findOneBy(['email' => $email]);

            if ($existingEmail) {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            } else {
                $entityManager->persist($newsletter);
                $entityManager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');
            }
        }

        $this->newsletterForm = $newsletterForm;
    }
}
