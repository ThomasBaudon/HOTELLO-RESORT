<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
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
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'name_service', 'description_service', 'image_service', 'slug'])
            ->setDefaultSort(['id' => 'ASC']);
    }


    public function configureFields(string $pageName): iterable
    {

            yield TextField::new('name_service');
            yield TextField::new('roomImages', 'Image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms();

            yield ImageField::new('image_service', 'Image')
                ->hideOnForm()
                ->setBasePath($this->uploadDir);
            yield TextareaField::new('description_service');
            yield TextField::new('image_service');
            yield TextField::new('slug');

                yield DateTimeField::new('created_at', 'Créé le');
                yield DateTimeField::new('updated_at', 'Modifié le');


    }
}
