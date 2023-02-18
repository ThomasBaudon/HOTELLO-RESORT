<?php

namespace App\Controller\Admin;

use App\Entity\BookingConfirmation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookingConfirmationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BookingConfirmation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail', Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Réservation')
            ->setEntityLabelInPlural('Réservations')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'start_date', 'end_date', 'created_at', 'adults_cap', 'children_cap'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('start_date', 'Arrivée');
        yield DateTimeField::new('end_date', 'Départ');
        yield DateTimeField::new('created_at', 'Créé le');
        yield IntegerField::new('adults_cap', 'Adultes');
        yield IntegerField::new('children_cap', 'Enfants');
        yield AssociationField::new('user', 'Client');
        yield TextField::new('user.email', 'mail client')
            ->setFormTypeOption('disabled', 'disabled')
            ->hideOnIndex()
        ;
        yield TextField::new('user.phone_user', 'Téléphone client')
            ->setFormTypeOption('disabled', 'disabled')
            ->hideOnIndex();
        yield AssociationField::new('room', 'Chambre');
        yield MoneyField::new('total_cost', 'Prix total')
        ->setCurrency('EUR')
        ->setNumDecimals(2)
        ->setStoredAsCents(false);


    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('start_date')
            ->add('end_date')
            ->add('created_at')
            ->add('adults_cap')
            ->add('children_cap');
    }
}
