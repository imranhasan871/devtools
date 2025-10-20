<?php

namespace Imran\DevTools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Imran\DevTools\Contracts\AccessControlInterface;

class EnsureDevtoolsAllowed
{
    public function __construct(
        protected AccessControlInterface $accessControl
    ) {}

    public function handle(Request $request, Closure $next)
    {
        // Check if devtools is enabled
        if (!$this->accessControl->isAllowed()) {
            abort(404);
        }

        // Check IP allowlist if configured
        if ($this->accessControl->shouldEnforceIpFiltering()) {
            if (!$this->accessControl->isIpAllowed($request->ip())) {
                abort(403, 'Access denied from this IP address.');
            }
        }

        return $next($request);
    }
}
