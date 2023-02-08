<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\UserCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;



class NewsletterCrudController extends AbstractCrudController 
// implements EventSubscriberInterface
{

    /* ----------------------------------------------------- */
    /* private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeCreatingEntity::class => 'checkEmail'
        ];
    }

    public function checkEmail(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Newsletter) {
            return;
        }

        $email = $entity->getEmail();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            $event->setArgument('message', "L'email appartient à un utilisateur enregistré");
            $entity->setClient($user->getName());
        }
    } */
    /* ----------------------------------------------------- */


    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }
    

    /* Configure */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Newsletter')
            ->setEntityLabelInPlural('Newsletters')
            ->setSearchFields(['id', 'client_id', 'email', 'created_at', 'subscription_status'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    /* Affichage et Traductions champs */
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();
        yield TextField::new('email', 'Email');

        yield AssociationField::new('client', 'Client')
            ->setCrudController(UserCrudController::class);

        yield DateTimeField::new('created_at', 'Date d\'inscription');
        yield BooleanField::new('subscription_status', 'Inscrit ?');


    }

    /* add filters */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('id')
            ->add('email')
            ->add('created_at')
            ->add('subscription_status');
    }
}
