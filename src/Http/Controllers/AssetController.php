<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Serves the package CSS and JS straight from the vendor directory so the UI
 * works before "vendor:publish --tag=ui-ai-kit-assets" has been run.
 */
class AssetController extends Controller
{
    protected const FILES = [
        'ui-ai-kit.css' => ['css/ui-ai-kit.css', 'text/css'],
        'landing.css' => ['css/landing.css', 'text/css'],
        'chatbot.js' => ['js/chatbot.js', 'application/javascript'],
        'landing.js' => ['js/landing.js', 'application/javascript'],
        'console.css' => ['css/console.css', 'text/css'],
        'console.js' => ['js/console.js', 'application/javascript'],
    ];

    public function __invoke(string $file): Response
    {
        if (! isset(self::FILES[$file])) {
            throw new NotFoundHttpException;
        }

        [$path, $mime] = self::FILES[$file];
        $full = __DIR__.'/../../../resources/'.$path;

        if (! is_file($full)) {
            throw new NotFoundHttpException;
        }

        return response((string) file_get_contents($full), 200, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
