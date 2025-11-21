<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\FormBuilderInterface;

// Approach 2: Manual Controller Handling
class BookManualCrudController extends AbstractCrudController
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

        yield IntegerField::new('page_count', 'Pages')
            ->setFormTypeOption('mapped', false);
        yield ChoiceField::new('cover_type', 'Cover')
            ->setChoices([
                'Hardcover' => 'hardcover',
                'Paperback' => 'paperback',
            ])
            ->setFormTypeOption('mapped', false);
        yield BooleanField::new('is_available', 'Available')
            ->setFormTypeOption('mapped', false);
    }

    // Manual process the form
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handleManualSpecs($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->handleManualSpecs($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleManualSpecs(Book $book): void
    {
        $request = $this->getContext()->getRequest();

        $bookFormData = $request->request->all()['Book'] ?? [];

        if (empty($bookFormData)) {
             return;
        }

        $specs = [
            'page_count' => isset($bookFormData['page_count']) ? (int) $bookFormData['page_count'] : null,
            'cover_type' => $bookFormData['cover_type'] ?? null,
            'is_available' => isset($bookFormData['is_available']) && $bookFormData['is_available'] === '1',
        ];

        $book->setSpecs($specs);
    }

    // Need to prefill form for edit
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $book = $entityDto->getInstance();
        $specs = $book->getSpecs();

        if ($builder->has('page_count')) $builder->get('page_count')->setData($specs['page_count'] ?? null);
        if ($builder->has('cover_type')) $builder->get('cover_type')->setData($specs['cover_type'] ?? null);
        if ($builder->has('is_available')) $builder->get('is_available')->setData($specs['is_available'] ?? false);

        return $builder;
    }
}
