<?php

namespace App\Controller\Admin\Field;

use App\Form\BookSpecsType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class BookSpecsField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(BookSpecsType::class)
            ->setTemplatePath('admin/field/specs.html.twig');
    }
}
