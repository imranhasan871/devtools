@php
// Fallback: if the app provides a `layouts.app` layout, use it. Otherwise render a minimal standalone page.
$hasLayout = View::exists('layouts.app');
@endphp

@if($hasLayout)
    @extends('layouts.app')

    @section('content')
        @include('devtools::partials.controls')
    @endsection
@else
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dev Tools</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Dev Tools</span>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            @include('devtools::partials.controls')
        </div>
    </main>
    </body>
    </html>
@endif
