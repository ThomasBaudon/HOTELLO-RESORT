<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
        yield IdField::new('id', 'id')
            ->hideOnForm();
        yield TextField::new('review', 'Avis');
        yield IntegerField::new('score', 'Score');
        yield AssociationField::new('id_user', 'Client')
            ->setCrudController(UserCrudController::class);
        yield AssociationField::new('id_room', 'Chambre')
            ->setCrudController(RoomCrudController::class);
        yield DateTimeField::new('created_at', 'Date de création');

        // return [
        //     TextareaField::new('review'),
        //     IntegerField::new('score'),
        //     IntegerField::new('id_user_id'),
        //     IntegerField::new('id_room_id'),
        //     DateTimeField::new('created_at'),

        // ];
    }
}
