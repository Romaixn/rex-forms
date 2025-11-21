<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CentsToMoneyTransformer implements DataTransformerInterface
{
    public function transform(mixed $valueInCents): ?float
    {
        if (null === $valueInCents) {
            return null;
        }

        return $valueInCents / 100;
    }

    public function reverseTransform(mixed $valueInMoney): ?int
    {
        if (null === $valueInMoney) {
            return null;
        }

        return (int) round($valueInMoney * 100);
    }
}
