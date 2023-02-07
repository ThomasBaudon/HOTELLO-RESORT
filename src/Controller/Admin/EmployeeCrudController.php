<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use PhpParser\Node\Expr\Yield_;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
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
            ->setEntityLabelInSingular('Employé')
            ->setEntityLabelInPlural('Employés')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['id', 'lastname_employee', 'firstname_employee', 'job_employee', 'photo_employee', 'arrival_date'])
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {

            Yield IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm();
            yield TextField::new('lastname_employee', 'Nom' );
            yield TextField::new('firstname_employee', 'Prénom');
            yield TextField::new('employePicFile', 'Photo')
                ->setFormType(VichImageType::class)
                ->onlyOnForms();
            yield ImageField::new('photo_employee', 'Image')
                ->hideOnForm()
                ->setBasePath($this->uploadDir);
            yield TextField::new('job_employee', 'Emploi');
            yield DateTimeField::new('arrival_date', 'Arrivé le');

            yield DateTimeField::new('created_at', 'Créé le')
                ->hideOnIndex()
                ->hideOnForm();

            yield DateTimeField::new('updated_at', 'Modifié le')
                ->hideOnIndex()
                ->hideOnForm();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('lastname_employee')
            ->add('firstname_employee')
            ->add('arrival_date')
            ->add('job_employee')
            ->add('created_at')
            ->add('updated_at');
    }
}
