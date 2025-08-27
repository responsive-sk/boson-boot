# 🚨 Emergency Response Guide - Malformed Headers

## Current Issue
```
[proxy_fcgi:error] malformed header from script 'index.php': Bad header: \xfd\xe0J\xc7\xefou.\x7fFC\xccd
[proxy_fcgi:error] AH01070: Error parsing script headers
```

## 🔥 Immediate Actions (Do This Now!)

### 1. Emergency Fix (30 seconds)
```bash
./bin/emergency-header-fix
```
This creates a bulletproof index.php and .htaccess immediately.

### 2. Test Basic Functionality
Visit: `https://yourdomain.com/test-minimal.php`
- If this works: Framework issue
- If this fails: Server/PHP issue

### 3. Emergency Production Build
```bash
./bin/build-emergency-production
./bin/package-for-upload emergency-build emergency-fix
```

## 🔍 Root Cause Analysis

The hex pattern `\xfd\xe0J\xc7\xefou.\x7fFC\xccd` indicates:

### Most Likely Causes:
1. **Compression Corruption** - Zlib/Gzip corrupting output
2. **Memory Corruption** - PHP memory issues
3. **Extension Interference** - Xdebug or other extensions
4. **Binary Data Injection** - Corrupt files or cache

### Less Likely:
- File encoding issues (BOM)
- Template corruption
- Database connection issues

## 🛠️ Emergency Solutions

### Solution 1: Disable Compression (Most Effective)
```php
// In index.php (already applied by emergency fix)
ini_set('zlib.output_compression', 0);
ini_set('output_buffering', 0);
```

### Solution 2: Clean Output Buffers
```php
// Clean all buffers before headers
while (ob_get_level()) {
    ob_end_clean();
}
```

### Solution 3: Disable Xdebug
```php
if (extension_loaded('xdebug')) {
    ini_set('xdebug.mode', 'off');
}
```

### Solution 4: Server-Level Fix (.htaccess)
```apache
php_flag zlib.output_compression Off
php_flag output_buffering Off
php_flag xdebug.mode off
```

## 📊 Diagnostic Steps

### 1. Check Server Logs
```bash
tail -f /var/log/apache2/error.log
tail -f /var/log/php8.4-fpm.log
```

### 2. Test Minimal PHP
```bash
echo '<?php phpinfo(); ?>' > test.php
curl -I https://yourdomain.com/test.php
```

### 3. Check PHP Configuration
```bash
php -m | grep -E "(xdebug|zlib|opcache)"
php -i | grep -E "(output_buffering|zlib)"
```

## 🚀 Deployment Options

### Option A: Emergency Patch (Fastest)
1. Run `./bin/emergency-header-fix`
2. Upload patched files
3. Test immediately

### Option B: Complete Emergency Build
1. Run `./bin/build-emergency-production`
2. Upload emergency-build package
3. Follow EMERGENCY-DEPLOYMENT.md

### Option C: Server Configuration
Contact hosting provider to:
- Disable zlib compression
- Disable Xdebug in production
- Check PHP-FPM configuration

## 📞 Escalation Path

### Level 1: Self-Service (0-15 minutes)
- [x] Run emergency fix script
- [x] Test minimal PHP script
- [x] Check basic server logs

### Level 2: Hosting Support (15-60 minutes)
- [ ] Contact hosting provider
- [ ] Request PHP configuration review
- [ ] Ask to disable problematic extensions

### Level 3: Developer Support (1+ hours)
- [ ] Deep dive into application logs
- [ ] Code review for corruption sources
- [ ] Custom debugging implementation

## 🔧 Prevention Measures

### Production Checklist:
- [ ] Disable Xdebug in production
- [ ] Disable zlib compression
- [ ] Enable proper error logging
- [ ] Set memory limits appropriately
- [ ] Use output buffering correctly
- [ ] Monitor server logs regularly

### Monitoring Setup:
```bash
# Add to cron for monitoring
*/5 * * * * grep "malformed header" /var/log/apache2/error.log | tail -1 | mail -s "Header Error" admin@domain.com
```

## 📋 Recovery Checklist

- [ ] Emergency fix applied
- [ ] Site accessibility confirmed
- [ ] Error logs reviewed
- [ ] Monitoring enabled
- [ ] Backup verified
- [ ] Team notified
- [ ] Post-incident review scheduled

## 🎯 Success Criteria

### Immediate (0-30 minutes):
- [ ] Site loads without 500 errors
- [ ] No malformed header errors in logs
- [ ] Basic functionality works

### Short-term (1-24 hours):
- [ ] Full application functionality restored
- [ ] Performance metrics normal
- [ ] Error rates below baseline

### Long-term (1+ days):
- [ ] Root cause identified and fixed
- [ ] Prevention measures implemented
- [ ] Documentation updated
- [ ] Team training completed

---

**Remember: In production emergencies, stability trumps features. Get the site working first, optimize later.**
