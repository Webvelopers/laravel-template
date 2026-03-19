<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

final class TemplatePreviewController extends Controller
{
    public function __invoke(string $template): View
    {
        /** @var list<string> $supportedTemplates */
        $supportedTemplates = config('frontend.templates.supported', []);

        abort_unless(in_array($template, $supportedTemplates, true), 404);

        return view('templates.preview', [
            'template' => $template,
        ]);
    }
}
