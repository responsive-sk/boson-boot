# Security Features

This document outlines the security measures implemented in the Boson PHP HTMX application.

## Security Headers

The application automatically sets the following security headers:

- `X-Content-Type-Options: nosniff` - Prevents MIME type sniffing
- `X-Frame-Options: DENY` - Prevents clickjacking attacks
- `X-XSS-Protection: 1; mode=block` - Enables XSS protection
- `Referrer-Policy: strict-origin-when-cross-origin` - Controls referrer information

## File Protection

### .htaccess Configuration

The application includes comprehensive .htaccess files that:

- Block access to sensitive files (.env, .htaccess, .ini, .log, etc.)
- Prevent access to version control directories (.git, .svn)
- Block access to configuration files (composer.json, package.json)
- Prevent PHP execution in upload directories
- Limit file upload size to 10MB

### Protected Directories

- `/src/` - Application source code
- `/templates/` - Template files
- `/database/` - Database files
- `/storage/` - Cache and session files
- `/vendor/` - Composer dependencies

## Input Validation

### InputValidator Class

The `InputValidator` class provides comprehensive input validation:

```php
$validator = new InputValidator();
$isValid = $validator->validate($data, [
    'email' => ['required', 'email'],
    'name' => ['required', 'string', ['min', 2], ['max', 100]],
    'age' => ['integer', ['min', 18]]
]);
```

### Supported Validation Rules

- `required` - Field must not be empty
- `string` - Must be a string
- `integer` - Must be an integer
- `email` - Must be valid email
- `url` - Must be valid URL
- `min` - Minimum length/value
- `max` - Maximum length/value
- `slug` - Valid slug format
- `alpha` - Letters only
- `alphanumeric` - Letters and numbers only
- `in` - Must be in allowed values
- `numeric` - Must be numeric
- `boolean` - Must be boolean
- `date` - Must be valid date
- `regex` - Must match pattern

### Input Sanitization

Static methods for sanitizing input:

- `InputValidator::sanitizeString()` - HTML escape
- `InputValidator::sanitizeEmail()` - Email sanitization
- `InputValidator::sanitizeUrl()` - URL sanitization
- `InputValidator::sanitizeInt()` - Integer sanitization
- `InputValidator::stripTags()` - Remove HTML tags

## CSRF Protection

### CsrfProtection Class

Protects against Cross-Site Request Forgery attacks:

```php
$csrf = new CsrfProtection();
$token = $csrf->generateToken('form_action');
$isValid = $csrf->validateToken($token, 'form_action');
```

### Features

- One-time use tokens
- Action-specific tokens
- Automatic token expiration (1 hour)
- Multiple token storage (max 10)
- Header and form field support

### Usage in Templates

```php
// Hidden input field
echo $csrf->getHiddenInput('form_action');

// Meta tag for AJAX
echo $csrf->getMetaTag('form_action');
```

## Rate Limiting

### RateLimiter Class

Prevents abuse and DoS attacks:

```php
$rateLimiter = new RateLimiter();
$identifier = $rateLimiter->getClientIdentifier();

if (!$rateLimiter->isAllowed($identifier, 60, 3600)) {
    // Rate limit exceeded
    http_response_code(429);
    exit;
}

$rateLimiter->recordAttempt($identifier);
```

### Default Limits

- **Global**: 100 requests per 5 minutes
- **Search**: 30 requests per 5 minutes
- **API**: Configurable per endpoint

### Client Identification

Uses combination of:
- IP address (with proxy support)
- User-Agent string
- SHA256 hashing for privacy

## Session Security

### Configuration

- Secure session handling
- HTTPOnly cookies
- SameSite cookie attribute
- Session regeneration on login
- Automatic session cleanup

### Storage

- File-based session storage
- Configurable session lifetime
- Automatic garbage collection

## Database Security

### Prepared Statements

All database queries use prepared statements to prevent SQL injection:

```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

### Query Caching

- Cached queries are sanitized
- Cache keys are hashed
- Automatic cache invalidation on writes

## File Upload Security

### Restrictions

- File type validation
- File size limits (10MB default)
- PHP execution prevention in upload directories
- Filename sanitization

### Configuration

```env
UPLOAD_MAX_SIZE=10485760
UPLOAD_ALLOWED_TYPES=jpg,jpeg,png,gif,webp
UPLOAD_PATH=./public/uploads
```

## Environment Security

### .env File Protection

- Blocked by .htaccess
- Contains sensitive configuration
- Should never be committed to version control

### Configuration Validation

- Type-safe configuration access
- Default value fallbacks
- Environment-specific settings

## Logging and Monitoring

### Error Handling

- Detailed errors in development
- Generic errors in production
- Error logging to files
- Performance monitoring

### Debug Information

- Only shown in debug mode
- Performance metrics
- Query information
- Memory usage tracking

## Best Practices

### Development

1. Always validate and sanitize input
2. Use prepared statements for database queries
3. Implement proper error handling
4. Enable CSRF protection for forms
5. Use rate limiting for APIs
6. Keep dependencies updated

### Production

1. Disable debug mode
2. Use HTTPS only
3. Set proper file permissions
4. Regular security updates
5. Monitor logs for suspicious activity
6. Implement proper backup strategy

### Configuration

1. Use strong passwords
2. Generate secure app keys
3. Configure proper session settings
4. Set appropriate cache TTL values
5. Limit file upload sizes
6. Configure rate limiting appropriately

## Security Checklist

- [ ] .htaccess files configured
- [ ] Security headers enabled
- [ ] Input validation implemented
- [ ] CSRF protection active
- [ ] Rate limiting configured
- [ ] File upload restrictions set
- [ ] Database queries use prepared statements
- [ ] Error handling configured
- [ ] Session security enabled
- [ ] Environment variables protected
- [ ] Debug mode disabled in production
- [ ] HTTPS configured (production)
- [ ] Regular security updates scheduled
