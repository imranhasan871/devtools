<?php

namespace Imran\DevTools\Services;

use Illuminate\Contracts\Foundation\Application;
use Imran\DevTools\Contracts\AccessControlInterface;

class AccessControlService implements AccessControlInterface
{
    public function __construct(
        protected Application $app,
        protected array $config
    ) {}

    /**
     * Check if devtools access is allowed for the current request.
     */
    public function isAllowed(): bool
    {
        $enabled = $this->config['enabled'] ?? null;

        if (is_null($enabled)) {
            return $this->isEnvironmentAllowed();
        }

        return (bool) $enabled;
    }

    /**
     * Check if the current environment is allowed.
     */
    public function isEnvironmentAllowed(): bool
    {
        $allowedEnvironments = $this->config['environments'] ?? ['local'];
        return in_array($this->app->environment(), $allowedEnvironments);
    }

    /**
     * Check if the current IP is allowed.
     */
    public function isIpAllowed(string $ip): bool
    {
        $allowedIps = $this->config['allowed_ips'] ?? [];

        // If no IPs configured, allow all when environment check passes
        if (empty($allowedIps)) {
            return true;
        }

        return in_array($ip, $allowedIps);
    }

    /**
     * Check if IP filtering should be enforced.
     */
    public function shouldEnforceIpFiltering(): bool
    {
        // Only enforce IP filtering in non-development environments
        return !$this->isEnvironmentAllowed() && !empty($this->config['allowed_ips']);
    }
}
