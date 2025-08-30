<?php
/**
 * Landing Layout - for marketing/landing pages
 * Includes header, hero section, dynamic sections, and footer
 */

$this->layout('layouts::base', [
    'title' => $title ?? 'Boson PHP',
    'description' => $description ?? 'Familiar PHP. Now for desktop applications.',
    'canonical' => $canonical ?? null,
    'ogImage' => $ogImage ?? null,
    'htmxExtensions' => $htmxExtensions ?? [],
    'bodyClass' => ($bodyClass ?? '') . ' landing-layout',
    'themeManager' => $themeManager ?? null,
])
?>

<?php $this->start('body') ?>

<!-- Header -->
<?php if (!isset($showHeader) || $showHeader): ?>
    <?php $this->insert('partials::header', [
        'currentRoute' => $currentRoute ?? 'home',
        'searchQuery' => $searchQuery ?? '',
        'blogCategories' => $blogCategories ?? [],
        'docsVersion' => $docsVersion ?? null,
        'docsCategories' => $docsCategories ?? [],
        'themeManager' => $themeManager ?? null,
    ]) ?>
<?php endif; ?>

<!-- Main Content -->
<main id="main-content" class="landing-content">
    <!-- Hero Section -->
    <?php if (isset($heroData)): ?>
        <?php $this->insert('partials::hero', $heroData) ?>
    <?php endif; ?>

    <!-- Dynamic Sections -->
    <?php if (isset($sections) && is_array($sections)): ?>
        <?php foreach ($sections as $section): ?>
            <?php if ($section['type'] === 'segment'): ?>
                <?php $this->insert('components/sections/segment', $section['data']) ?>
            <?php elseif ($section['type'] === 'testimonials'): ?>
                <?php $this->insert('components/sections/testimonials', $section['data'] ?? []) ?>
            <?php elseif ($section['type'] === 'cta'): ?>
                <?php $this->insert('components/sections/call-to-action', $section['data']) ?>
            <?php elseif ($section['type'] === 'custom'): ?>
                <?= $section['content'] ?>
            <?php elseif ($section['type'] === 'component'): ?>
                <?php $this->insert($section['template'], $section['data'] ?? []) ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Additional content -->
    <?= $this->section('main') ?>
</main>

<!-- Footer -->
<?php if (!isset($showFooter) || $showFooter): ?>
    <?php $this->insert('partials::footer', [
        'themeManager' => $themeManager ?? null,
        'currentRoute' => $currentRoute ?? '',
    ]) ?>
<?php endif; ?>

<?php $this->stop() ?>

<?php $this->start('head') ?>
<style>
.landing-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.landing-content {
    flex: 1;
    padding-top: 80px; /* Account for fixed header */
}

@media (max-width: 768px) {
    .landing-content {
        padding-top: 70px; /* Smaller padding on mobile */
    }
}
</style>
<?php $this->stop() ?>
