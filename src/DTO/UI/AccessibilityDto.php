<?php

namespace App\DTO\UI;

readonly class AccessibilityDto
{
    public function __construct(
        public string $highContrastClass = 'default-contrast',
    ) {}
}
