<?php
/**
 * Home Page - exact replica of original mark.responsive.sk
 * Using the same structure as litjs-template/app/home.php
 */

// Hero style configuration - change this to test different styles
$heroStyle = $_GET['hero'] ?? 'tailwind'; // Options: 'tailwind', 'svelte', 'alpine'

// Use landing layout for home page
$this->layout('layouts::landing', [
    'title' => 'Boson PHP - Go Native. Stay PHP.',
    'description' => 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.',
    'keywords' => 'PHP, Desktop Applications, Native Apps, Cross-platform, Boson PHP, Web Technologies, Electron Alternative',
    'currentRoute' => 'home',
    'canonical' => 'https://mark.responsive.sk/',
    'ogImage' => '/images/og-home.png',
    'themeManager' => $themeManager ?? null, // Add ThemeManager support
    'heroData' => [
        'heroStyle' => $heroStyle, // Pass hero style to layout
        'title' => 'Go Native. Stay PHP.',
        'subtitle' => 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.',
        'primaryButton' => ['text' => 'Try Boson For Free', 'url' => '/docs/latest/installation'],
        'secondaryButton' => ['text' => 'Download Now', 'url' => '/download']
    ]
]);
?>

<?php $this->start('main') ?>

<!-- Landing page sections will be handled by landing layout -->
<!-- Additional sections beyond hero -->

    <!-- Call to Action Section -->
    <?php $this->insert('components/sections/call-to-action') ?>

    <!-- How It Works Visual Section -->
    <?php $this->insert('components/sections/how-it-works') ?>

    <!-- Right Choice Section -->
    <?php $this->insert('components/sections/right-choice') ?>

    <!-- Mobile Development Section with Rich API -->
    <?php $this->insert('components/sections/mobile-development') ?>

    <!-- Testimonials Section -->
    <?php $this->insert('components/sections/segment', [
        'type' => 'center',
        'sectionName' => 'Testimonials',
        'title' => 'Developers that<br />believe in us'
    ]) ?>

    <?php $this->insert('components/sections/testimonials') ?>

<?php $this->stop() ?>



