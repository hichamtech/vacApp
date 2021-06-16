<?php

namespace App\Controller\Admin;

use App\Entity\Destination;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * Class DestinationCrudController
 * @package App\Controller\Admin
 */
class DestinationCrudController extends AbstractCrudController
{
    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Destination::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('country'),
            TextField::new('monument'),
            TextEditorField::new('description'),
            TextField::new('type'),
            ImageField::new('filename', 'Image')
                ->onlyOnIndex()
                ->setBasePath('/images/destinations'),
            VichImageField::new('imageFile')->onlyOnForms(),



        ];
    }

}
