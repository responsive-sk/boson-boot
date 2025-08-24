<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Performance and SEO meta tags -->
    <meta name="theme-color" content="#000000">
    <meta name="color-scheme" content="light dark">
    <meta name="format-detection" content="telephone=no">
    
    <?php if (isset($metaTags)): ?>
        <?= $metaTags ?>
    <?php endif; ?>
    
    <title><?= $this->escapeHtml($title ?? 'Boson') ?></title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $this->escapeHtml($description ?? 'Boson PHP - Familiar PHP. Now for desktop applications. Build native desktop apps with PHP using modern web technologies.') ?>">
    <meta name="keywords" content="<?= $this->escapeHtml($keywords ?? 'PHP, Desktop Applications, Native Apps, Cross-platform, Boson PHP, Web Technologies') ?>">
    <meta name="author" content="Boson PHP Team">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $this->escapeHtml($canonical ?? 'https://mark.responsive.sk/') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= $this->escapeHtml($title ?? 'Boson PHP') ?>">
    <meta property="og:description" content="<?= $this->escapeHtml($description ?? 'Familiar PHP. Now for desktop applications. Build native desktop apps with PHP using modern web technologies.') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $this->escapeHtml($canonical ?? 'https://mark.responsive.sk/') ?>">
    <meta property="og:image" content="<?= $this->escapeHtml($ogImage ?? '/images/og-image.png') ?>">
    <meta property="og:site_name" content="Boson PHP">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $this->escapeHtml($title ?? 'Boson PHP') ?>">
    <meta name="twitter:description" content="<?= $this->escapeHtml($description ?? 'Familiar PHP. Now for desktop applications.') ?>">
    <meta name="twitter:image" content="<?= $this->escapeHtml($ogImage ?? '/images/og-image.png') ?>">

    <!-- Note: Font preloading disabled for demo - in production, add actual font files -->
    <!-- Preload logo to prevent layout shift -->
    <link rel="preload" href="/images/logo.svg" as="image" type="image/svg+xml">

    <!-- CSS - using existing compiled styles from Lit version -->
    <?php if (isset($cssUrl) && $cssUrl): ?>
        <link rel="stylesheet" href="<?= $cssUrl ?>">
    <?php endif; ?>

    <link rel="icon" type="image/png" sizes="16x16" href="/images/logo.png">

    <!-- HTMX Core -->
    <script src="https://unpkg.com/htmx.org@1.9.10" defer></script>
    
    <!-- Alpine.js for complex interactions -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Performance and Accessibility styles -->
    <style>
        /* Skip link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #000;
            color: #fff;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
            font-size: 14px;
            transition: top 0.3s;
        }
        .skip-link:focus {
            top: 6px;
        }

        /* Logo sizing to prevent layout shift */
        .logo {
            width: 255px;
            height: 100px;
            max-width: 100%;
            height: auto;
            aspect-ratio: 255/100;
            object-fit: contain;
        }

        /* Font fallbacks to reduce layout shift */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        /* Font loading with proper fallbacks */
        .font-inter,
        body.fonts-loaded {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        .font-roboto-condensed {
            font-family: 'Roboto Condensed', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        .font-jetbrains-mono {
            font-family: 'JetBrains Mono', 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
        }

        /* Reduce font loading flash */
        @media (prefers-reduced-motion: no-preference) {
            body {
                transition: font-family 0.1s ease-in-out;
            }
        }

        /* HTMX loading indicators */
        .htmx-indicator {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .htmx-request .htmx-indicator {
            opacity: 1;
        }
        .htmx-request.htmx-indicator {
            opacity: 1;
        }
    </style>

    <!-- Font loading optimization -->
    <script>
        // Detect when fonts are loaded to reduce layout shift
        if ('fonts' in document) {
            document.fonts.ready.then(function() {
                document.body.classList.add('fonts-loaded');
            });
        }
    </script>
</head>
<body lang="<?= substr($locale ?? 'en', 0, 2) ?>">
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php if (!isset($showHeader) || $showHeader): ?>
        <?php $this->insert('partials::header', [
            'blogCategories' => $blogCategories ?? [],
            'docsVersion' => $docsVersion ?? null,
            'docsCategories' => $docsCategories ?? [],
            'currentRoute' => $currentRoute ?? '',
            'searchQuery' => $searchQuery ?? '',
        ]) ?>
    <?php endif; ?>

    <main id="main-content">
        <?= $this->section('main') ?>
    </main>

    <?php if (!isset($showFooter) || $showFooter): ?>
        <?php $this->insert('partials::footer') ?>
    <?php endif; ?>

    <!-- HTMX Extensions if needed -->
    <?php if (isset($htmxExtensions) && $htmxExtensions): ?>
        <?php foreach ($htmxExtensions as $extension): ?>
            <script src="https://unpkg.com/htmx.org/dist/ext/<?= $extension ?>.js"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Custom JavaScript for enhanced interactions -->
    <?php if (isset($jsUrl) && $jsUrl): ?>
        <script type="module" src="<?= $jsUrl ?>" defer></script>
    <?php endif; ?>
</body>
</html>
