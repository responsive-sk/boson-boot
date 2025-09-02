# Templating Infrastructure Refactor

## Information Gathered
- AssetManager.php: Already secured with path validation, input sanitization, no $_SERVER usage.
- ThemeManager.php: Has theme validation, but uses $_SERVER in resolveHashedAsset method, needs path validation for asset paths.
- TemplateEngine.php: Uses hardcoded routes in url helper, no path validation for templates, basic helpers.
- TemplateEngineWithCache.php: Uses $_SERVER in url helper, no path validation, file operations not secured.
- Code duplication between engines in helper functions.
- Current issues: Security vulnerabilities, missing validation, hardcoded values, code duplication.

## Plan
- [x] Secure ThemeManager.php: Remove $_SERVER usage, add path validation for asset paths
- [x] Secure TemplateEngine.php: Add template path validation, secure helper functions, remove hardcoded routes
- [x] Secure TemplateEngineWithCache.php: Add path validation, secure file operations, remove $_SERVER usage
- [x] Add comprehensive error handling for missing templates/assets
- [x] Add type safety improvements (strict types, parameter validation)
- [x] Create common helper class to remove code duplication
- [ ] Update TODO-Templating-Audit.md to reflect progress
- [ ] Add security-focused unit tests

## Dependent Files to Edit
- src/Shared/Infrastructure/Templating/ThemeManager.php
- src/Shared/Infrastructure/Templating/TemplateEngine.php
- src/Shared/Infrastructure/Templating/TemplateEngineWithCache.php
- TODO-Templating-Audit.md

## Followup Steps
- Run existing tests to ensure no regressions
- Create unit tests for security features
- Test template rendering with various inputs
- Verify asset loading and path resolution
