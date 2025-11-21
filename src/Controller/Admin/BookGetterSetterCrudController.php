<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

// Approach 1: Getter/Setter (Virtual Properties)
class BookGetterSetterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title');
        yield MoneyField::new('price')->setCurrency('EUR')->setStoredAsCents(true);

        yield IntegerField::new('pageCount', 'Pages');
        yield ChoiceField::new('coverType', 'Cover')
            ->setChoices([
                'Hardcover' => 'hardcover',
                'Paperback' => 'paperback',
            ]);
        yield BooleanField::new('isAvailable', 'Available');
    }
}
