@extends('ui-ai-kit::layouts.landing')

@php($landingSections = data_get($content, 'sections', ['hero', 'logos', 'assistant-preview', 'features', 'how-it-works', 'stats', 'pricing', 'testimonials', 'faqs', 'cta']))
@php($availableLandingSections = ['hero', 'logos', 'assistant-preview', 'features', 'how-it-works', 'stats', 'pricing', 'testimonials', 'faqs', 'cta'])

@section('content')
    @include('ui-ai-kit::landing.sections.nav')

    <main>
        @foreach ($landingSections as $section)
            @if (is_string($section) && in_array($section, $availableLandingSections, true))
                @include('ui-ai-kit::landing.sections.' . $section)
            @endif
        @endforeach
    </main>

    @include('ui-ai-kit::landing.sections.footer')
@endsection
