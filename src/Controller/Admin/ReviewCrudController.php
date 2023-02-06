<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {        
        return $crud
            ->setEntityLabelInSingular('Avis')
            ->setEntityLabelInPlural('Avis')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'review', 'score', 'image_service', 'id_user_id', 'id_room_id'])
            ->setDefaultSort(['id' => 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('review', 'Avis');
        yield IntegerField::new('score', 'Score');
        yield AssociationField::new('id_user', 'Client')
            ->setCrudController(UserCrudController::class);
        yield AssociationField::new('id_room', 'Chambre')
            ->setCrudController(RoomCrudController::class);

        return [
            TextareaField::new('review'),
            IntegerField::new('score'),
            IntegerField::new('id_user_id'),
            IntegerField::new('id_room_id'),

        ];
    }

    // public function configureFilters(Filters $filters): Filters{
    //     return $filters
    //         ->add('review', [
    //             'label' => 'Avis'
    //         ])
    //         ->add('score' , [
    //             'label' => 'Score'
    //         ])
    //         ->add('id_user_id', [
    //             'label' => 'Client'
    //         ])
    //         ->add('id_room_id' , [
    //             'label' => 'Chambre'
    //         ]);
    // }
}
