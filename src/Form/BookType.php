<?php

namespace App\Form;

use App\Entity\Book;
use App\Form\DataTransformer\CentsToMoneyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function __construct(
        private CentsToMoneyTransformer $centsToMoneyTransformer
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'help' => 'Enter price in currency (e.g. 10.50)',
            ])
            ->add('specs', BookSpecsType::class, [
                'label' => 'Specifications',
            ]);

        // Apply the transformer to the price field
        $builder->get('price')->addModelTransformer($this->centsToMoneyTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
