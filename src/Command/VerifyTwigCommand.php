<?php

namespace App\Command;

use App\DTO\UI\ButtonComponentDto;
use App\DTO\UI\ButtonStateDto;
use App\DTO\UI\ButtonMetaDto;
use App\DTO\UI\ButtonThemeDto;
use App\DTO\UI\AccessibilityDto;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

#[AsCommand(
    name: 'app:verify-twig',
    description: 'Verify Twig 3.24 features',
)]
class VerifyTwigCommand extends Command
{
    public function __construct(
        private readonly Environment $twig
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->renderScenario($output, 'Rendering with all features', new ButtonComponentDto(
            type: 'primary',
            state: new ButtonStateDto(disabled: true, loading: true),
            meta: new ButtonMetaDto(analyticsId: 'btn_checkout_123', ariaLabel: null),
            theme: new ButtonThemeDto(new AccessibilityDto(highContrastClass: 'ultra-contrast'))
        ));

        $this->renderScenario($output, 'Rendering with null theme (null-safe check)', new ButtonComponentDto(
            type: 'secondary',
            state: new ButtonStateDto(disabled: false, loading: false),
            meta: new ButtonMetaDto(analyticsId: 'btn_back', ariaLabel: 'Go Back'),
            theme: null
        ));

        return Command::SUCCESS;
    }

    private function renderScenario(OutputInterface $output, string $title, ButtonComponentDto $dto): void
    {
        $output->writeln(\sprintf("\n--- %s ---", $title));
        try {
            $rendered = $this->twig->render('ui/components/_button.html.twig', [
                'payload' => $dto
            ]);
            $output->writeln($rendered);
        } catch (\Exception $e) {
            $output->writeln(\sprintf('<error>Error: %s</error>', $e->getMessage()));
        }
    }
}
