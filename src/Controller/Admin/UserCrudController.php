<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail', Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Client')
            ->setEntityLabelInPlural('Clients')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'email', 'lastname_user', 'firstname_user', 'adress_user', 'city_user', 'zip_user', 'phone_user', 'country_user', 'birthdate_user'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('lastname_user', 'Nom');
        yield TextField::new('firstname_user', 'Prénom');
        yield TextField::new('email', 'Email');
        yield TextField::new('password')
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnIndex()
                ->hideOnForm();
        yield TextField::new('phone_user', 'Téléphone');
        yield TextField::new('adress_user', 'Adresse');
        yield TextField::new('zip_user', 'Code postal');
        yield TextField::new('city_user', 'Ville');
        yield TextField::new('country_user', 'Pays');
        yield DateTimeField::new('created_at', 'Date d\'inscription')
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnIndex();
        yield DateTimeField::new('birthdate_user', 'Date de naissance')
                ->hideOnIndex();
        yield ArrayField::new('roles')
                ->hideOnIndex();

    }

     public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('lastname_user')
            ->add('firstname_user')
            ->add('email')
            ->add('phone_user')
            ->add('adress_user')
            ->add('zip_user')
            ->add('city_user')
            ->add('country_user')
            ->add('birthdate_user')
            ->add('created_at')
            ->add('roles');
    }
}
