<?php

namespace App\Controller\Admin;

use App\Entity\Pictures;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
        return Pictures::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('categories'),
            TextEditorField::new('description'),
            NumberField::new('prices')->hideOnIndex(),
        ];
    }
}
