<?php

namespace App\DTO\UI;

readonly class ButtonStateDto
{
    public function __construct(
        public bool $disabled = false,
        public bool $loading = false,
    ) {}
}
