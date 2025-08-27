# Troubleshooting Guide

## Malformed HTTP Headers Error

### Error Message
```
[proxy_fcgi:error] malformed header from script 'index.php': Bad header: B\xa3\xfe\x88...
[proxy_fcgi:error] AH01070: Error parsing script headers
```

### Root Cause
This error occurs when PHP scripts output binary data or unexpected content before HTTP headers, commonly caused by:

1. **Xdebug Extension** - Outputs debug information before headers
2. **BOM (Byte Order Mark)** - UTF-8 BOM in PHP files
3. **Whitespace** - Spaces/newlines before `<?php` tags
4. **Binary Data** - Corrupted files or binary content in templates
5. **PHP Extensions** - Extensions outputting data prematurely

### Diagnosis Tools

#### Quick Check
```bash
./tools/check-headers
```

#### Comprehensive Diagnosis
```bash
./bin/diagnose-headers
```

#### BOM Removal
```bash
./bin/fix-bom
```

### Solutions

#### 1. Production Fix (Recommended)
```bash
./bin/fix-production-headers
```

This script:
- Adds output buffering to index.php
- Disables error display in production
- Disables Xdebug output
- Creates .htaccess for Apache
- Creates Nginx configuration snippet

#### 2. Manual Fixes

**For Apache (.htaccess):**
```apache
php_flag display_errors off
php_flag log_errors on
php_flag xdebug.mode off
```

**For Nginx:**
```nginx
fastcgi_param PHP_VALUE "display_errors=0";
fastcgi_param PHP_VALUE "xdebug.mode=off";
```

**In PHP code (index.php):**
```php
<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);
if (extension_loaded('xdebug')) {
    ini_set('xdebug.mode', 'off');
}

// Your application code here

ob_end_flush();
```

#### 3. Server-Level Fixes

**Disable Xdebug in production:**
```bash
# In php.ini
zend_extension=xdebug.so
xdebug.mode=off
```

**Or remove Xdebug entirely:**
```bash
sudo phpdismod xdebug
sudo systemctl restart php8.4-fpm
```

### Prevention

1. **Development Environment:**
   - Use proper IDE settings
   - Configure Xdebug correctly
   - Use UTF-8 without BOM encoding

2. **Production Environment:**
   - Disable debug extensions
   - Enable error logging instead of display
   - Use output buffering
   - Monitor error logs

3. **Code Quality:**
   - No whitespace before `<?php`
   - No content after `?>`
   - Proper file encoding (UTF-8 without BOM)
   - Regular code reviews

### Testing

After applying fixes, test with:

```bash
# Test HTTP headers
curl -I http://your-domain.com/

# Test specific pages
curl -I http://your-domain.com/articles
curl -I http://your-domain.com/search

# Check for binary data
curl -s http://your-domain.com/ | hexdump -C | head -5
```

### Monitoring

Set up monitoring for:
- HTTP 500 errors
- PHP error logs
- Server error logs
- Response time anomalies

### Emergency Response

If the issue occurs in production:

1. **Immediate Fix:**
   ```bash
   ./bin/fix-production-headers
   systemctl restart php-fpm
   systemctl restart apache2/nginx
   ```

2. **Rollback Plan:**
   - Keep backup of original index.php
   - Have previous working version ready
   - Monitor error logs continuously

3. **Communication:**
   - Notify stakeholders
   - Document the incident
   - Plan post-incident review
