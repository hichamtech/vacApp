<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class PostCrudController
 * @package App\Controller\Admin
 */
class PostCrudController extends AbstractCrudController
{
    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('message'),
           'likes',
            ImageField::new('filename', 'Image')
                  ->onlyOnIndex()
                  ->setBasePath('/images/posts'),
            VichImageField::new('imageFile')->onlyOnForms(),

        ];
    }

}
