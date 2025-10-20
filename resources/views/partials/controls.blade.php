@if(session('status'))
    <div class="alert alert-info" role="alert" style="white-space:pre-wrap">{{ session('status') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Development Utilities</h5>
        <p class="card-text">Quick actions for local development. These endpoints should not be publicly exposed in production.</p>

        <div class="d-flex">
            <form method="post" action="{{ route('dev.migrate') }}">
                @csrf
                <button class="btn btn-primary me-2" type="submit">Run Migrations</button>
            </form>

            <form method="post" action="{{ route('dev.seed') }}">
                @csrf
                <button class="btn btn-secondary me-2" type="submit">Run Seeders</button>
            </form>

            <a href="{{ route('dev.clean') }}" class="btn btn-outline-success">Clear Caches (JSON)</a>
        </div>
    </div>
</div>

<p class="mt-3 text-muted">Enabled environments: {{ implode(', ', config('devtools.environments', ['local'])) }}</p>
