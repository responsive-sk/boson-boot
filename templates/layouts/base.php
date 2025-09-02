<!DOCTYPE html>
<html lang="<?= $lang ?? 'en' ?>" class="<?= $htmlClass ?? '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?= $this->escapeHtml($title ?? 'Boson PHP') ?></title>
    <meta name="description" content="<?= $this->escapeHtml($description ?? 'Familiar PHP. Now for desktop applications.') ?>">
    <meta name="keywords" content="<?= $this->escapeHtml($keywords ?? 'PHP, Desktop, Applications, Native, Cross-platform') ?>">
    <meta name="author" content="<?= $this->escapeHtml($author ?? 'Boson PHP Team') ?>">

    <!-- Resource hints for better performance -->
    <?php if (isset($themeManager)): ?>
        <?php $themeFonts = $themeManager->getThemeFonts(); ?>
        <?php if (isset($themeFonts['inter-400'])): ?>
            <!-- Preload critical fonts -->
            <link rel="preload" href="<?= $themeManager->getFontUrl($themeFonts['inter-400']) ?>" as="font" type="font/woff2" crossorigin>
        <?php endif; ?>
        <?php if (isset($themeFonts['inter-600'])): ?>
            <link rel="preload" href="<?= $themeManager->getFontUrl($themeFonts['inter-600']) ?>" as="font" type="font/woff2" crossorigin>
        <?php endif; ?>

        <!-- Preload critical CSS (remove JS preload to avoid warning) -->
        <link rel="preload" href="<?= $themeManager->getCssUrl() ?>" as="style">

        <!-- DNS prefetch for external resources -->
        <?php if ($themeManager->getCurrentTheme() === 'tailwind'): ?>
            <link rel="dns-prefetch" href="//cdn.tailwindcss.com">
        <?php endif; ?>
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <?php endif; ?>

    <!-- Canonical URL -->
    <?php if (isset($canonical)): ?>
        <link rel="canonical" href="<?= $this->escapeHtml($canonical) ?>">
    <?php endif; ?>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= $this->escapeHtml($ogTitle ?? $title ?? 'Boson PHP') ?>">
    <meta property="og:description" content="<?= $this->escapeHtml($ogDescription ?? $description ?? 'Familiar PHP. Now for desktop applications.') ?>">
    <meta property="og:type" content="<?= $ogType ?? 'website' ?>">
    <meta property="og:url" content="<?= $this->escapeHtml($ogUrl ?? '') ?>">
    <meta property="og:image" content="<?= $this->escapeHtml($ogImage ?? '/images/og-image.png') ?>">
    <meta property="og:site_name" content="Boson PHP">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $this->escapeHtml($twitterTitle ?? $title ?? 'Boson PHP') ?>">
    <meta name="twitter:description" content="<?= $this->escapeHtml($twitterDescription ?? $description ?? 'Familiar PHP. Now for desktop applications.') ?>">
    <meta name="twitter:image" content="<?= $this->escapeHtml($twitterImage ?? $ogImage ?? '/images/og-image.png') ?>">
    
    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/logo.png">
    
    <!-- Preload critical resources -->
    <!-- Logo preload removed - not used immediately -->
    
    <!-- CSS -->
    <?php if (isset($themeManager)): ?>
        <link rel="stylesheet" href="<?= $themeManager->getCssUrl() ?>" media="all">
    <?php elseif (isset($cssFiles) && is_array($cssFiles)): ?>
        <?php foreach ($cssFiles as $cssFile): ?>
            <link rel="stylesheet" href="<?= $cssFile ?>" media="all">
        <?php endforeach; ?>
    <?php elseif (isset($cssUrl)): ?>
        <link rel="stylesheet" href="<?= $cssUrl ?>" media="all">
    <?php else: ?>
        <link rel="stylesheet" href="/assets/svelte/main.css" media="all">
    <?php endif; ?>

    <!-- Critical CSS inline for layout stability -->
    <style>
        /* Font loading optimization */
        <?php if (isset($themeManager)): ?>
            <?php $themeFonts = $themeManager->getThemeFonts(); ?>
            <?php if (isset($themeFonts['inter-400'])): ?>
        @font-face {
            font-family: 'Inter';
            src: url('<?= $themeManager->getFontUrl($themeFonts['inter-400']) ?>') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap; /* Prevent FOUC */
        }
            <?php endif; ?>
            <?php if (isset($themeFonts['inter-600'])): ?>
        @font-face {
            font-family: 'Inter';
            src: url('<?= $themeManager->getFontUrl($themeFonts['inter-600']) ?>') format('woff2');
            font-weight: 600;
            font-style: normal;
            font-display: swap; /* Prevent FOUC */
        }
            <?php endif; ?>
        <?php else: ?>
        @font-face {
            font-family: 'Inter';
            src: url('/assets/svelte/inter-400.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap; /* Prevent FOUC */
        }

        @font-face {
            font-family: 'Inter';
            src: url('/assets/svelte/inter-600.woff2') format('woff2');
            font-weight: 600;
            font-style: normal;
            font-display: swap; /* Prevent FOUC */
        }
        <?php endif; ?>

        /* Prevent layout shift during font loading */
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Reserve space for header */
        .header-container {
            min-height: 80px;
        }

        /* Reserve space for footer */
        .footer-container {
            min-height: 200px;
        }

        /* Reserve space for hero */
        .hero-section {
            min-height: 100vh;
        }

        /* Prevent layout shift in nativeness section */
        .nativeness-section {
            min-height: 500px;
        }

        /* Loading state to prevent FOUC */
        .svelte-loading {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .svelte-loaded {
            opacity: 1;
        }
    </style>

    <!-- Tailwind CSS for hybrid components -->
    <?php if (isset($useTailwind) && $useTailwind): ?>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'boson-orange': '#7a1a1a',
                            'boson-dark': '#0d1119',
                            'boson-gray': '#0f131c'
                        }
                    }
                }
            }
        </script>
    <?php endif; ?>
    
    <!-- HTMX and Alpine.js are now bundled in theme assets -->
    
    <!-- Additional head content -->
    <?= $this->section('head') ?>
    
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
        
        /* Prevent layout shift */
        .logo {
            width: 255px;
            height: 40px;
        }
        
        /* Loading state */
        .htmx-indicator {
            display: none;
        }
        .htmx-request .htmx-indicator {
            display: inline;
        }
        .htmx-request.htmx-indicator {
            display: inline;
        }
    </style>
</head>
<body class="<?= ($bodyClass ?? '') . (isset($themeManager) ? ' ' . $themeManager->getThemeClasses() : '') ?>" <?= isset($bodyAttributes) ? $bodyAttributes : '' ?>>
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Page content -->
    <?= $this->section('body') ?>
    
    <!-- HTMX Extensions (if needed, should be bundled too) -->
    <?php if (isset($htmxExtensions) && is_array($htmxExtensions)): ?>
        <!-- Extensions should be bundled in theme assets -->
        <!-- <?php foreach ($htmxExtensions as $extension): ?>
            <script src="/assets/htmx-ext/<?= $extension ?>.js"></script>
        <?php endforeach; ?> -->
    <?php endif; ?>
    
    <!-- Custom JavaScript -->
    <?php if (isset($themeManager)): ?>
        <script type="module" src="<?= $themeManager->getJsUrl() ?>" defer></script>
    <?php elseif (isset($jsFiles) && is_array($jsFiles)): ?>
        <?php foreach ($jsFiles as $jsFile): ?>
            <script type="module" src="<?= $jsFile ?>" defer></script>
        <?php endforeach; ?>
    <?php elseif (isset($jsUrl)): ?>
        <script type="module" src="<?= $jsUrl ?>" defer></script>
    <?php endif; ?>
    
    <!-- Additional scripts -->
    <?= $this->section('scripts') ?>
</body>
</html>
