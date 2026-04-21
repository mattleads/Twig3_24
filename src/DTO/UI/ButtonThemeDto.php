<?php

namespace App\DTO\UI;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ButtonThemeDto
{
    public function __construct(
        #[Assert\Valid]
        public AccessibilityDto $accessibility,
    ) {}
}
