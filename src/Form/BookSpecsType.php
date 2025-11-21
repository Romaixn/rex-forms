<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSpecsType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('page_count', IntegerType::class, [
                'label' => 'Page Count',
            ])
            ->add('cover_type', ChoiceType::class, [
                'label' => 'Cover Type',
                'choices' => [
                    'Hardcover' => 'hardcover',
                    'Paperback' => 'paperback',
                ],
            ])
            ->add('is_available', CheckboxType::class, [
                'label' => 'Available',
                'required' => false,
            ]);

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'empty_data' => null,
        ]);
    }

    /**
     * Maps the view data (the JSON array from the entity) to the form fields.
     *
     * @param array|null $viewData The data from the entity (specs array)
     * @param \Traversable|FormInterface[] $forms The form fields
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        if (null === $viewData) {
            $viewData = [];
        }

        $forms = iterator_to_array($forms);

        $forms['page_count']->setData($viewData['page_count'] ?? null);
        $forms['cover_type']->setData($viewData['cover_type'] ?? null);
        $forms['is_available']->setData($viewData['is_available'] ?? false);
    }

    /**
     * Maps the form data (submitted fields) back to the view data (the JSON array).
     *
     * @param \Traversable|FormInterface[] $forms The form fields
     * @param mixed &$viewData The data to be updated (passed by reference)
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);

        $viewData = [
            'page_count' => $forms['page_count']->getData(),
            'cover_type' => $forms['cover_type']->getData(),
            'is_available' => $forms['is_available']->getData(),
        ];
    }
}
