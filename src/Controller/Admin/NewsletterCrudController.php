<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class NewsletterCrudController extends AbstractCrudController
{
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
