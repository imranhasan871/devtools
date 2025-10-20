# Imran DevTools

A professional Laravel development utility package providing a clean UI and API for common development tasks like cache clearing, migrations, and database seeding.

## Features

- 🎨 **Clean UI** - Standalone web interface for development tools
- 🔒 **Secure by Default** - Only loads in development environments
- 🏗️ **SOLID Architecture** - Built with design patterns and best practices
- 🧪 **Testable** - Fully decoupled with dependency injection
- ⚙️ **Configurable** - Extensive configuration options
- 🛡️ **IP Allowlist** - Optional IP-based access control

## Installation

Install via Composer:

```bash
composer require imran/devtools
```

The package will be auto-discovered by Laravel.

## Usage

### Web UI

Visit `http://your-app.test/dev` to access the development tools UI with buttons for:

- **Run Migrations** - Execute database migrations with `--force`
- **Run Seeders** - Execute database seeders
- **Clear Caches** - Clear all Laravel caches (returns JSON)

### API Endpoints

- `GET /dev` - Web UI
- `GET /dev/clean` - Clear caches (JSON response)
- `POST /dev/migrate` - Run migrations
- `POST /dev/seed` - Run seeders

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Imran\DevTools\DevToolsServiceProvider" --tag="devtools-config"
```

This creates `config/devtools.php`:

```php
return [
    // Enable/disable devtools (null = auto-enable in local environments)
    'enabled' => env('DEVTOOLS_ENABLED', null),

    // Allowed environments when enabled is null
    'environments' => ['local', 'development', 'dev'],

    // Middleware stack for routes
    'middleware' => ['web'],

    // Optional IP allowlist for non-local environments
    'allowed_ips' => [],
];
```

### Customizing Views

Publish the views to customize the UI:

```bash
php artisan vendor:publish --provider="Imran\DevTools\DevToolsServiceProvider" --tag="devtools-views"
```

Views will be published to `resources/views/vendor/devtools/`.

## Security

**Important:** This package is designed for development only and follows security best practices:

1. **Environment Checks** - Routes only load in `local`, `development`, or `dev` environments by default
2. **Configurable Access** - Use `DEVTOOLS_ENABLED=false` to disable completely
3. **Middleware Protection** - Add custom middleware in config: `'middleware' => ['web', 'auth', 'can:admin']`
4. **IP Allowlist** - Configure `allowed_ips` array for IP-based restrictions
5. **Production Safety** - Middleware automatically blocks access when not in allowed environments

### Enabling in Production (Not Recommended)

If you must enable in non-local environments:

```php
// config/devtools.php
return [
    'enabled' => true,
    'middleware' => ['web', 'auth', 'can:admin'],
    'allowed_ips' => ['127.0.0.1', '192.168.1.100'],
];
```

## Architecture

This package follows SOLID principles and clean architecture:

### Contracts (Interfaces)

- `CommandExecutorInterface` - Abstraction for command execution
- `AccessControlInterface` - Abstraction for access control logic

### Services

- `ArtisanCommandService` - Handles Artisan command execution with error handling
- `AccessControlService` - Manages environment and IP-based access control

### Design Patterns

- **Dependency Injection** - All dependencies injected via constructor
- **Single Responsibility** - Each class has one reason to change
- **Interface Segregation** - Small, focused interfaces
- **Dependency Inversion** - Depend on abstractions, not concretions
- **Service Layer** - Business logic separated from controllers

## Testing

The package is built to be fully testable. Mock the interfaces in your tests:

```php
use Imran\DevTools\Contracts\CommandExecutorInterface;

$this->mock(CommandExecutorInterface::class, function ($mock) {
    $mock->shouldReceive('execute')
        ->once()
        ->andReturn(new CommandResult('migrate', true, 'Success'));
});
```

## License

MIT License. See [LICENSE](LICENSE) for details.
