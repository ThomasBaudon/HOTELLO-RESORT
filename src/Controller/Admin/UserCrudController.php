<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
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
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('lastname_user'),
            TextField::new('firstname_user'),
            TextField::new('email')
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('phone_user'),
            TextField::new('password')
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('adress_user'),
            TextField::new('zip_user'),
            TextField::new('city_user'),
            TextField::new('country_user'),
            DateTimeField::new('birthdate_user'),
            DateTimeField::new('created_at')
                ->setFormTypeOption('disabled', 'disabled')
                ->hideOnForm(),
            ArrayField::new('roles'),
        ];
    }
}
