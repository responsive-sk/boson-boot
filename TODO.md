# TODO - Bug Fixes

## Completed Fixes

### 1. ArticleStatus Enum Casting Issue
- **Problem**: "Object of class Boson\Blog\Domain\ArticleStatus could not be converted to string" error in /articles endpoint
- **Root Cause**: PHP 8.1+ backed enums cannot be cast to string using (string) operator
- **Solution**: Changed `(string) $status` to `$status->value` in SqliteArticleRepository.php
- **Files Modified**:
  - `src/Blog/Infrastructure/SqliteArticleRepository.php` (save, findByStatus, countByStatus methods)
- **Status**: ✅ Fixed

### 2. Invalid Theme Error
- **Problem**: "Invalid theme: svelteAvailablesveltetailwindbootstrap" causing rendering failure
- **Root Cause**: $_ENV['THEME'] contained invalid concatenated string, sanitization didn't validate against valid themes
- **Solution**: Added validation in ServiceFactory.php to check against valid themes array and fallback to 'tailwind'
- **Files Modified**:
  - `src/Shared/Infrastructure/ServiceFactory.php` (createThemeManager method)
- **Status**: ✅ Fixed

### 3. Font Loading 404 Errors
- **Problem**: 404 errors for font files (inter-400.woff2, inter-500.woff2, etc.) when loading tailwind theme
- **Root Cause**: ThemeManager.getFontUrl() was returning theme-specific paths (/assets/tailwind/font.woff2) but fonts are shared in /fonts/
- **Solution**: Updated getFontUrl() to return shared font paths (/fonts/font.woff2)
- **Files Modified**:
  - `src/Shared/Infrastructure/Templating/ThemeManager.php` (getFontUrl method)
- **Status**: ✅ Fixed

### 4. Missing Alpine.js Footer
- **Problem**: Footer missing when using tailwind theme (only svelte footer was implemented)
- **Root Cause**: footer.php had empty Alpine.js footer section
- **Solution**: Added proper Alpine.js footer content with navigation links and copyright
- **Files Modified**:
  - `templates/partials/footer.php`
- **Status**: ✅ Fixed

## Testing
- Test /articles endpoint to ensure no more enum casting errors
- Test theme rendering with various $_ENV['THEME'] values
- Verify fallback to 'tailwind' theme works correctly
- Verify fonts load correctly from /fonts/ path (no more 404 errors)
- Verify footer appears on all pages when using tailwind theme
- Check Alpine.js header styling and functionality (may need CSS updates)

## Remaining Issues
- Alpine.js header styling may need CSS updates in tailwind theme
- Verify that Alpine.js header renders correctly with proper styling

## Notes
- ArticleStatus is a PHP 8.1+ backed enum with values: 'draft', 'published', 'archived'
- Valid themes: 'svelte', 'tailwind', 'bootstrap'
- Theme fallback ensures application doesn't crash on invalid theme configuration
- Fonts are shared across themes and located in /fonts/
- Header and footer partials support both Svelte and Alpine.js themes
- Alpine.js header uses classes like "header", "nav", "aside" that may need theme-specific CSS
