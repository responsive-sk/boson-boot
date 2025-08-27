# Deployment Instructions for Shared Hosting

## Pre-deployment Checklist
- [ ] Backup existing website
- [ ] Prepare database credentials
- [ ] Ensure PHP 8.1+ is available
- [ ] Check available disk space

## Deployment Steps

### 1. Upload Files
Upload all contents of this build directory to your shared hosting:
- Upload `public_html/` contents to your domain's public folder
- Upload other directories (`src/`, `templates/`, `vendor/`, etc.) to a private folder above public_html

### 2. Configure Environment
```bash
cp .env.production .env
nano .env  # Edit with your settings
```

### 3. Install Dependencies (if composer available)
```bash
composer install --no-dev --optimize-autoloader
```

### 4. Set File Permissions
```bash
chmod 755 public_html/
chmod 644 public_html/.htaccess
chmod 644 public_html/index.php
chmod -R 755 storage/
chmod -R 644 storage/cache/
chmod -R 644 storage/logs/
```

### 5. Database Setup
- Import your database schema
- Update database credentials in .env
- Test database connection

### 6. Test Application
- Visit your domain
- Check error logs: `storage/logs/`
- Test main functionality

## Maintenance Scripts

### Clear Cache
```bash
php maintenance/clear-cache.php
```

### Check Status
```bash
php maintenance/health-check.php
```

## Troubleshooting

### Common Issues
1. **500 Internal Server Error**
   - Check .htaccess syntax
   - Verify file permissions
   - Check error logs

2. **Database Connection Failed**
   - Verify credentials in .env
   - Check database server status
   - Ensure database exists

3. **Missing Dependencies**
   - Run composer install
   - Check PHP version compatibility
   - Verify required extensions

### Support
- Check `storage/logs/php_errors.log`
- Check `storage/logs/app.log`
- Contact hosting provider if needed

## Security Notes
- Never expose .env file
- Keep storage/ directory private
- Regular security updates
- Monitor error logs
- Use HTTPS in production
