<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

/**
 * Serves the full-page, dashboard-style chatbot UI (sidebar, header, message
 * thread, right-hand info panel) as an alternative to the floating widget.
 */
class ConsoleController extends Controller
{
    public function __invoke(): View
    {
        return view('ui-ai-kit::console.index');
    }
}
