<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        return view('ui-ai-kit::landing.index', [
            'content' => config('ui-ai-kit.content', []),
            'branding' => config('ui-ai-kit.branding', []),
        ]);
    }
}
