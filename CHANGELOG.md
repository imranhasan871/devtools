# Changelog

All notable changes to `imran/devtools` will be documented in this file.

## [1.0.0] - 2025-10-20

### Added

- Initial release
- Web UI for development tools at `/dev`
- Cache clearing endpoint (`/dev/clean`)
- Database migration runner (`POST /dev/migrate`)
- Database seeder runner (`POST /dev/seed`)
- Configurable access control with environment and IP filtering
- Middleware protection for all routes
- SOLID architecture with service layer
- Dependency injection throughout
- Contracts/interfaces for easy testing and extension
- Comprehensive documentation and README
- MIT License

### Security

- Routes only load in development environments by default
- Configurable middleware stack
- IP allowlist support
- Environment-based access control
