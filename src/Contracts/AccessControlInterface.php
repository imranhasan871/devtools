<?php

namespace Imran\DevTools\Contracts;

interface AccessControlInterface
{
    /**
     * Check if devtools access is allowed for the current request.
     *
     * @return bool
     */
    public function isAllowed(): bool;

    /**
     * Check if the current environment is allowed.
     *
     * @return bool
     */
    public function isEnvironmentAllowed(): bool;

    /**
     * Check if the current IP is allowed.
     *
     * @param string $ip
     * @return bool
     */
    public function isIpAllowed(string $ip): bool;
}
