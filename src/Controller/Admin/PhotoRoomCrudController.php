<?php

namespace App\Controller\Admin;

use App\Entity\PhotoRoom;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoRoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PhotoRoom::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Photo Chambre')
            ->setEntityLabelInPlural('Photos Chambres')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'path_photo', 'created_at', 'updated_at'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();
        yield TextField::new('path_photo', 'Image');
        yield DateTimeField::new('created_at', 'Créé le');
        yield DateTimeField::new('updated_at', 'Modifié le');
    }

}
