<?php
/**
 * Landing Layout - converted from Lit boson-landing-layout component
 * Main layout for landing pages with proper spacing between sections
 */

$this->layout('layout::master', [
    'title' => $title ?? 'Boson PHP',
    'description' => $description ?? 'Familiar PHP. Now for desktop applications.',
    'showHeader' => $showHeader ?? true,
    'showFooter' => $showFooter ?? true,
    'cssUrl' => $cssUrl ?? '/assets/app.css',
    'currentRoute' => $currentRoute ?? 'home',
    'htmxExtensions' => $htmxExtensions ?? [],
    'metaTags' => $metaTags ?? null,
    'canonical' => $canonical ?? null,
    'ogImage' => $ogImage ?? null,
])
?>

<?php $this->start('main') ?>

<main class="landing-layout">
    <!-- Hero Section -->
    <?php if (isset($heroData)): ?>
        <?php $this->insert('components::hero-section', $heroData) ?>
    <?php endif; ?>

    <!-- Dynamic Sections -->
    <?php if (isset($sections) && is_array($sections)): ?>
        <?php foreach ($sections as $section): ?>
            <?php if ($section['type'] === 'segment'): ?>
                <?php $this->insert('components::segment-section', $section['data']) ?>
            <?php elseif ($section['type'] === 'custom'): ?>
                <?= $section['content'] ?>
            <?php elseif ($section['type'] === 'component'): ?>
                <?php $this->insert($section['template'], $section['data'] ?? []) ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Additional content -->
    <?php if (isset($additionalContent)): ?>
        <?= $additionalContent ?>
    <?php endif; ?>
</main>

<?php $this->stop() ?>



