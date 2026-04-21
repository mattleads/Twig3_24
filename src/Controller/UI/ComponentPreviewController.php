<?php

namespace App\Controller\UI;

use App\DTO\UI\ButtonComponentDto;
use App\DTO\UI\ButtonMetaDto;
use App\DTO\UI\ButtonStateDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ComponentPreviewController extends AbstractController
{
    #[Route('/ui/preview/button', name: 'ui_preview_button', methods: ['POST'])]
    public function preview(
        #[MapRequestPayload] ButtonComponentDto $componentPayload
    ): Response {

        return $this->render('ui/components/preview.html.twig', [
            'payload' => $componentPayload,
        ]);
    }

    #[Route('/ui/preview/button', name: 'ui_preview_button_get', methods: ['GET'])]
    public function previewGet(Request $request): Response
    {
        $isSubmitted = $request->query->getBoolean('submit');

        $defaultPayload = new ButtonComponentDto(
            type: $isSubmitted ? 'secondary' : 'primary',
            state: new ButtonStateDto(disabled: $isSubmitted, loading: $isSubmitted),
            meta: new ButtonMetaDto(analyticsId: 'btn_default', ariaLabel: 'Default Button'),
            theme: null
        );

        return $this->render('ui/components/preview.html.twig', [
            'payload' => $defaultPayload,
            'is_submitted' => $isSubmitted
        ]);
    }
}
