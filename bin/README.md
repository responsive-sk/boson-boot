# Production Scripts

This directory contains production-ready scripts for application maintenance and deployment.

## Scripts

### `migrate`
Database migration script for production deployment.

```bash
./bin/migrate
```

**Purpose**: Creates database tables and seeds initial data
**When to use**: During deployment, after database schema changes
**Requirements**: Database configuration in .env file

### `cache-cleanup`
Automated cache cleanup for production maintenance.

```bash
./bin/cache-cleanup
```

**Purpose**: Removes expired cache entries to free disk space
**When to use**: As a cron job or during maintenance windows
**Frequency**: Recommended daily or weekly

### `build-shared-hosting`
Creates optimized build for shared hosting Apache deployment.

```bash
./bin/build-shared-hosting [target-directory]
```

**Purpose**: Builds production-ready package for shared hosting
**Features**: Security hardening, performance optimization, Apache configuration
**Output**: Complete build directory with deployment instructions

### `package-for-upload`
Creates compressed archive from build directory.

```bash
./bin/package-for-upload [build-dir] [output-name]
```

**Purpose**: Packages build into uploadable tar.gz archive
**When to use**: After building for shared hosting
**Output**: Compressed archive with upload instructions

### `deploy-shared-hosting`
One-command build and package for shared hosting.

```bash
./bin/deploy-shared-hosting [version]
```

**Purpose**: Complete build, package, and documentation generation
**Features**: Versioned builds, deployment summaries, upload instructions
**Output**: Ready-to-upload package with complete documentation

## Cron Job Examples

```bash
# Daily cache cleanup at 2 AM
0 2 * * * /path/to/project/bin/cache-cleanup >> /var/log/cache-cleanup.log 2>&1

# Weekly cache cleanup on Sundays at 3 AM
0 3 * * 0 /path/to/project/bin/cache-cleanup >> /var/log/cache-cleanup.log 2>&1
```

## Error Handling

All scripts:
- Return exit code 0 on success
- Return exit code 1 on failure
- Log errors to stderr
- Provide descriptive error messages

## Permissions

Scripts are executable and include shebang for direct execution:
```bash
chmod +x bin/*
```
