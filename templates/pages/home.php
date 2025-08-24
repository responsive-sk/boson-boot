<?php
/**
 * Home Page - exact replica of original mark.responsive.sk
 * Using the same structure as lidjs-template/app/home.php
 */

// Use exact same layout structure as original
$this->layout('layout::master', [
    'title' => 'Boson PHP - Go Native. Stay PHP.',
    'description' => 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.',
    'keywords' => 'PHP, Desktop Applications, Native Apps, Cross-platform, Boson PHP, Web Technologies, Electron Alternative',
    'showHeader' => true,
    'showFooter' => true,
    'cssUrl' => '/assets/app.css',
    'currentRoute' => 'home',
    'canonical' => 'https://mark.responsive.sk/',
    'ogImage' => '/images/og-home.png'
]);
?>

<?php $this->start('main') ?>

<!-- Exact replica of original home page structure -->
<div class="landing-layout">
    <!-- Hero Section -->
    <?php $this->insert('components::hero-section', [
        'title' => 'Go Native.',
        'subtitle' => 'Stay PHP',
        'description' => 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.',
        'buttonText' => 'Try Boson for Free',
        'buttonUrl' => '/docs/latest/installation',
        'buttonIcon' => '/images/icons/arrow_primary.svg',
        'discoveryText' => 'Discover more about boson',
        'discoveryUrl' => '#nativeness',
        'showLogo' => true
    ]) ?>

    <!-- Nativeness Section -->
    <?php $this->insert('components::segment-section', [
        'type' => 'horizontal',
        'sectionName' => 'Nativeness',
        'title' => 'Familiar PHP. Now for desktop applications.',
        'content' => '<p>"What makes you think PHP is only for the web?"<br />– Boson is changing the rules of the game!</p>',
        'anchorId' => 'nativeness'
    ]) ?>

    <!-- Nativeness Visual Section -->
    <?php $this->insert('components::nativeness-section') ?>

    <!-- Solves Section -->
    <?php $this->insert('components::segment-section', [
        'type' => 'horizontal',
        'sectionName' => 'Solves',
        'title' => 'What you <span class="emphasis">can do</span> with<br/>Boson?',
        'content' => '<ul>
                        <li>Launch any ready-made web project in a Desktop environment without a browser and server.</li>
                        <li>Compile an application for the desired desktop platform based on an existing PHP project.</li>
                      </ul>'
    ]) ?>

    <!-- Solves Visual Section -->
    <?php $this->insert('components::solves-section') ?>

    <!-- How It Works Section -->
    <?php $this->insert('components::segment-section', [
        'type' => 'horizontal',
        'sectionName' => 'How It Works',
        'title' => 'Under the Hood of<br />Boson',
        'content' => '<p>Why Boson? Because it\'s not Electron! And much lighter...</p>
                     <p>Want to know what makes Boson so compact, fast and versatile? We don\'t use Electron or other Chromium instance builds. Instead, our solution is based on simple, yet robust and up-to-date technologies that provide native performance and lightweight across all platforms.</p>'
    ]) ?>

    <!-- How It Works Visual Section -->
    <?php $this->insert('components::how-it-works-section') ?>

    <!-- Right Choice Section -->
    <?php $this->insert('components::right-choice-section') ?>

    <!-- Mobile Development Section with Rich API -->
    <?php $this->insert('components::mobile-development-section') ?>

    <!-- Testimonials Section -->
    <?php $this->insert('components::segment-section', [
        'type' => 'center',
        'sectionName' => 'Testimonials',
        'title' => 'Developers that<br />believe in us'
    ]) ?>

    <?php $this->insert('components::testimonials-section') ?>

    <!-- Call to Action Section -->
    <?php $this->insert('components::call-to-action-section') ?>
</div>

<?php $this->stop() ?>



