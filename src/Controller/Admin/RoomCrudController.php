<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoomCrudController extends AbstractCrudController
{

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail', Action::DETAIL);
    }

    public function __construct(private string $uploadDir)
    {     
    }

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
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title_room', 'Titre');
        yield TextField::new('type_room', 'Type');
        yield MoneyField::new('price_room', 'Prix')
        ->setCurrency('EUR')
        ->setNumDecimals(2)
        ->setStoredAsCents(false);
        yield IntegerField::new('size_room', 'Taille (m2)');
        yield TextareaField::new('description_room', 'Description')
        ->hideOnIndex();
        yield IntegerField::new('adults_cap', 'NB. Adultes');
        yield IntegerField::new('children_cap', 'NB. Enfants');
        yield BooleanField::new('status_room', 'Occup??e');
        // yield TextField::new('slug', 'Slug');

        yield TextField::new('roomMainImage', 'Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield ImageField::new('image', 'Image')
            ->hideOnForm()
            ->setBasePath($this->uploadDir);

        yield SlugField::new('slug', 'Slug')
            ->setTargetFieldName('title_room');

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
                'label' => 'Capacit?? adultes'
            ])
            ->add('children_cap' , null, [
                'label' => 'Capacit?? enfants'
            ])
            ->add('status_room' , null, [
                'label' => 'Occup??e'
            ])
            ->add('slug' , null, [
                'label' => 'Slug'
            ]);
    }

}
