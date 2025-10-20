<?php

return [
    /**
     * Enable or disable the devtools UI/routes. Defaults to true in local.
     */
    'enabled' => env('DEVTOOLS_ENABLED', null), // null = auto-enable in local envs

    /**
     * Environments where the routes should be auto-loaded if 'enabled' is null.
     */
    'environments' => ['local', 'development', 'dev'],

    /**
     * Middleware to apply to the devtools routes. You can use 'web', 'auth',
     * 'can:admin' or a custom middleware alias registered in your app.
     */
    'middleware' => ['web'],

    /**
     * Optional allowlist of IPs when running in non-local environments.
     * Example: ['127.0.0.1']
     */
    'allowed_ips' => [],
];
