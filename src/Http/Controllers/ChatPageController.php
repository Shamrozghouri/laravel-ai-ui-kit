<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class ChatPageController extends Controller
{
    public function __invoke(): View
    {
        return view('ui-ai-kit::chat-page.index');
    }
}
