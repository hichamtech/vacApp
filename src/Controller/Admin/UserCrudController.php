<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class UserCrudController
 * @package App\Controller\Admin
 */
class UserCrudController extends AbstractCrudController
{
    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('pseudo'),
            DateField::new('userAge'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('phone'),
            ImageField::new('filename', 'Image')
                ->onlyOnIndex()
                ->setBasePath('/images/users'),
            VichImageField::new('imageFile')->onlyOnForms(),
            ChoiceField::new('roles')->setChoices(
                [
                    'User' => User::ROLE_USER,
                    'Admin' => User::ROLE_ADMIN,
                ]
            )->allowMultipleChoices(),
            TextField::new('password',"Password")->setFormType(PasswordType::class)->hideOnIndex()->hideOnDetail(),


        ];
    }

}
