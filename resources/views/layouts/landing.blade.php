<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('ui-ai-kit.landing.title', config('ui-ai-kit.branding.name')))</title>
    <meta name="description" content="{{ config('ui-ai-kit.branding.tagline') }}">

    @if (config('ui-ai-kit.theme.load_fonts', true))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @endif

    {!! \Shamrozghouri\LaravelUiAiKit\UiAiKit::assetTags() !!}
    @stack('ui-ai-kit-head')
</head>
<body class="uiaikit" data-uiaikit-theme="{{ config('ui-ai-kit.theme.mode', 'dark') }}" style="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::themeVariables() }}">
    @yield('content')

    <x-ui-ai-kit::chatbot />

    <script src="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('js/landing.js') }}" defer></script>
    @stack('ui-ai-kit-scripts')
</body>
</html>
