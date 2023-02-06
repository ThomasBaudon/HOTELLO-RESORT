<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    /* Configure */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Contact')
            ->setEntityLabelInPlural('Contacts')
            ->setSearchFields(['id', 'lastname_contact', 'firstname_contact', 'email_contact', 'phone_contact', 'message_contact'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    /* Affichage et Traductions champs */
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('lastname_contact', 'Nom');
        yield TextField::new('firstname_contact', 'Prénom');
        yield TextField::new('email_contact', 'Email');
        yield TextField::new('phone_contact', 'Téléphone');
        yield TextareaField::new('message_contact', 'Message');
        yield DateTimeField::new('created_at', 'Date de création');

        return [
            TextField::new('lastname_contact'),
            TextField::new('firstname_contact'),
            TextField::new('email_contact'),
            TextField::new('phone_contact'),
            TextareaField::new('message_contact'),
        ];
    }

    /* add filters */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('lastname_contact')
            ->add('firstname_contact')
            ->add('email_contact')
            ->add('phone_contact')
            ->add('message_contact')
            ->add('created_at');
    }
}
