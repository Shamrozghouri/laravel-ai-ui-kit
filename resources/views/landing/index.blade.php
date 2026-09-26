@extends('ui-ai-kit::layouts.landing')

@section('content')
    @include('ui-ai-kit::landing.sections.nav')

    <main>
        @include('ui-ai-kit::landing.sections.hero')
        @include('ui-ai-kit::landing.sections.logos')
        @include('ui-ai-kit::landing.sections.features')
        @include('ui-ai-kit::landing.sections.how-it-works')
        @include('ui-ai-kit::landing.sections.stats')
        @include('ui-ai-kit::landing.sections.pricing')
        @include('ui-ai-kit::landing.sections.testimonials')
        @include('ui-ai-kit::landing.sections.cta')
    </main>

    @include('ui-ai-kit::landing.sections.footer')
@endsection
