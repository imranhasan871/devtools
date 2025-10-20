<?php

namespace Imran\DevTools\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Imran\DevTools\Contracts\CommandExecutorInterface;
use Imran\DevTools\Contracts\AccessControlInterface;

class DevController extends Controller
{
    public function __construct(
        protected CommandExecutorInterface $commandExecutor,
        protected AccessControlInterface $accessControl
    ) {}

    /**
     * Show the devtools UI.
     */
    public function index(Request $request): Renderable
    {
        return view('devtools::index');
    }

    /**
     * Run a set of cleaning commands and return JSON output.
     */
    public function clean(): JsonResponse
    {
        $commands = [
            'optimize:clear',
            'config:clear',
            'route:clear',
            'view:clear',
        ];

        $results = $this->commandExecutor->executeMultiple($commands);

        return response()->json([
            'ok' => collect($results)->every(fn($r) => $r->success),
            'environment' => app()->environment(),
            'results' => array_map(fn($r) => $r->toArray(), $results),
        ]);
    }

    /**
     * Run migrations.
     */
    public function migrate(Request $request): RedirectResponse
    {
        $this->ensureLocalEnvironment();

        $result = $this->commandExecutor->execute('migrate', ['--force' => true]);

        $this->flashResult($request, 'Migrate', $result);

        return redirect()->route('dev.index');
    }

    /**
     * Run database seeders.
     */
    public function seed(Request $request): RedirectResponse
    {
        $this->ensureLocalEnvironment();

        $result = $this->commandExecutor->execute('db:seed');

        $this->flashResult($request, 'Seed', $result);

        return redirect()->route('dev.index');
    }

    /**
     * Ensure we're in a local environment.
     */
    protected function ensureLocalEnvironment(): void
    {
        if (!$this->accessControl->isEnvironmentAllowed()) {
            abort(403, 'This action is only allowed in development environments.');
        }
    }

    /**
     * Flash command result to session.
     */
    protected function flashResult(Request $request, string $action, $result): void
    {
        $message = $result->success
            ? "{$action}: OK\n{$result->output}"
            : "{$action} failed: {$result->error}";

        $request->session()->flash('status', $message);
    }
}
