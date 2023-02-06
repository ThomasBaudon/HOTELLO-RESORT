<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Chambre')
            ->setEntityLabelInPlural('Chambres')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'title_room', 'description_room', 'type_room', 'slug'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title_room', 'Titre');
        yield IntegerField::new('price_room', 'Prix');
        yield TextField::new('type_room', 'Type');
        yield IntegerField::new('size_room', 'Taille');
        yield TextareaField::new('description_room', 'Description');
        yield IntegerField::new('adults_cap', 'Capacité adultes');
        yield IntegerField::new('children_cap', 'Capacité enfants');
        yield BooleanField::new('status_room', 'Occupée');
        yield TextField::new('slug', 'Slug');

        return [
            TextField::new('title_room'),
            IntegerField::new('price_room'),
            TextField::new('type_room'),
            IntegerField::new('size_room'),
            TextareaField::new('description_room'),
            IntegerField::new('adults_cap'),
            IntegerField::new('children_cap'),
            BooleanField::new('status_room'),
            TextField::new('slug'),
            // 'created_at',
            // 'image',
            // 'updated_at',
        ];
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('title_room', null, [
                'label' => 'Titre'
            ])
            ->add('price_room' , null, [
                'label' => 'Prix'
            ])
            ->add('type_room', null, [
                'label' => 'Type'
            ])
            ->add('size_room' , null, [
                'label' => 'Taille'
            ])
            ->add('description_room' , null, [
                'label' => 'Description'
            ])
            ->add('adults_cap' , null, [
                'label' => 'Capacité adultes'
            ])
            ->add('children_cap' , null, [
                'label' => 'Capacité enfants'
            ])
            ->add('status_room' , null, [
                'label' => 'Occupée'
            ])
            ->add('slug' , null, [
                'label' => 'Slug'
            ]);
    }

}
