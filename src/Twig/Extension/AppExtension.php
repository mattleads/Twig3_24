<?php

namespace App\Twig\Extension;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private readonly NormalizerInterface $normalizer
    ) {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('cast_to_array', [$this, 'castToArray']),
        ];
    }

    public function castToArray($object): array
    {
        return $this->normalizer->normalize($object);
    }
}
