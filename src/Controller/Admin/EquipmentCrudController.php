<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class EquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function __construct(private string $uploadDir)
    {     
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail', Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Équipement')
            ->setEntityLabelInPlural('Équipements')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'name', 'description_equipment'])
            ->setDefaultSort(['id' => 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        
        yield TextField::new('roomIcon', 'Image')
        ->setFormType(VichImageType::class)
        ->onlyOnForms();
        
        yield ImageField::new('icon', 'Image')
        ->hideOnForm()
        ->setBasePath($this->uploadDir);
        
        yield TextField::new('name');
        yield TextareaField::new('description_equipment');
            
        yield DateTimeField::new('created_at', 'Créé le')
        ->setFormTypeOption('disabled', 'disabled')
         ->hideOnIndex();

        yield DateTimeField::new('updated_at', 'Modifié le')
        ->setFormTypeOption('disabled', 'disabled')
        ->hideOnIndex();

        yield AssociationField::new('room', 'Chambre(s)')
            ->hideOnIndex()
            ->hideOnDetail()
            ->setCrudController(RoomCrudController::class);

        yield CollectionField::new('room', 'Chambre(s)')
            ->hideOnForm()
            ->setTemplatePath('admin/equipment/room.html.twig');

    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('name')
            ->add('description_equipment')
            ->add('created_at')
            ->add('updated_at')
            ->add('room');
    }
}
