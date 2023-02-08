<?php
namespace App\Entity\Trait;

namespace App\Traits;

use App\Entity\Newsletter;
use App\Form\NewsletterFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

trait NewsletterTrait
{
    private function handleNewsletterSubscription(Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, FlashBagInterface $flashBag)
    {
        $newsletter = new Newsletter();
        $newsletterForm = $formFactory->create(NewsletterFormType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        $form_submitted = $newsletterForm->isSubmitted();

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $newsletter = $newsletterForm->getData();
            $email = $newsletterForm->get('email')->getData();

            $existingEmail = $entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['email' => $email]);

            $subscription_status = $entityManager
                ->getRepository(Newsletter::class)
                ->findOneBy(['subscription_status' => 1]);

            if ($existingEmail) {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
                // return $this->redirectToRoute('app_main');
            } elseif ($subscription_status === 1) {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à notre newsletter !');
            } else {
                $entityManager->persist($newsletter);
                $entityManager->flush();
                $this->addFlash('success', 'Merci ! Votre email a bien été enregistré !');
                // return $this->redirectToRoute('app_main');
            }
        }

        return [
            'form' => $newsletterForm->createView(),
            'form_submitted' => $form_submitted,
        ];
    }
}

?>