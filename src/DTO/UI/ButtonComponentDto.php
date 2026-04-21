<?php

namespace App\DTO\UI;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ButtonComponentDto
{
    public function __construct(
        #[Assert\Choice(choices: ['primary', 'secondary', 'danger', 'ghost'])]
        public string $type,
        
        #[Assert\Valid]
        public ButtonStateDto $state,
        
        #[Assert\Valid]
        public ButtonMetaDto $meta,

        #[Assert\Valid]
        public ?ButtonThemeDto $theme = null,
    ) {}
}
