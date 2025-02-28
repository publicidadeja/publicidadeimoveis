@push('header')
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4a90e2">
    <link rel="apple-touch-icon" href="/images/icon-192x192.png">
@endpush

{!! Theme::partial('header') !!}

<div id="app">
    <div id="ismain-homes">
        {!! Theme::content() !!}
    </div>
</div>

{!! Theme::partial('footer') !!}

