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
