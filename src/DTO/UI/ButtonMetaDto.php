<?php

namespace App\DTO\UI;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ButtonMetaDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $analyticsId,
        public ?string $ariaLabel = null,
    ) {}
}
