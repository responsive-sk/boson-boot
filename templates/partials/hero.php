<?php
/**
 * Hybrid Hero partial - supports multiple hero styles
 * Styles: tailwind, svelte, alpine (default)
 */

$heroStyle = $heroStyle ?? 'alpine'; // Default to Alpine.js
$title = $title ?? 'Go Native. Stay PHP.';
$subtitle = $subtitle ?? 'Turn your PHP project into cross-platform, compact, fast, native applications for Windows, Linux and macOS.';
$primaryButton = $primaryButton ?? ['text' => 'Try Boson For Free', 'url' => '/docs/latest/installation'];
$secondaryButton = $secondaryButton ?? ['text' => 'Download Now', 'url' => '/download'];
?>

<?php if ($heroStyle === 'tailwind'): ?>
    <!-- Svelte TailwindHero -->
    <div id="svelte-tailwind-hero"
         data-title="<?= htmlspecialchars($title) ?>"
         data-subtitle="<?= htmlspecialchars($subtitle) ?>"
         data-primary-button="<?= htmlspecialchars(json_encode($primaryButton)) ?>"
         data-secondary-button="<?= htmlspecialchars(json_encode($secondaryButton)) ?>"></div>

<?php elseif ($heroStyle === 'svelte'): ?>
    <!-- Svelte Hero -->
    <div id="svelte-hero" 
         data-title="<?= htmlspecialchars($title) ?>" 
         data-subtitle="<?= htmlspecialchars($subtitle) ?>"
         data-primary-button="<?= htmlspecialchars(json_encode($primaryButton)) ?>"
         data-secondary-button="<?= htmlspecialchars(json_encode($secondaryButton)) ?>"></div>

<?php else: ?>
    <!-- Default Alpine.js Hero (current implementation) -->
    <section class="hero-section" 
             x-data="{
                 dots: [],
                 init() {
                     this.createFloatingDots();
                     setInterval(() => this.animateDots(), 3000);
                 },
                 createFloatingDots() {
                     for (let i = 0; i < 20; i++) {
                         this.dots.push({
                             id: i,
                             x: Math.random() * 100,
                             y: Math.random() * 100,
                             size: Math.random() * 4 + 2,
                             opacity: Math.random() * 0.5 + 0.3,
                             speed: Math.random() * 2 + 1
                         });
                     }
                 },
                 animateDots() {
                     this.dots = this.dots.map(dot => ({
                         ...dot,
                         x: Math.random() * 100,
                         y: Math.random() * 100,
                         opacity: Math.random() * 0.5 + 0.3
                     }));
                 }
             }">
        
        <!-- Floating dots background -->
        <div class="dots-background">
            <template x-for="dot in dots" :key="dot.id">
                <div class="floating-dot"
                     :style="`left: ${dot.x}%; top: ${dot.y}%; width: ${dot.size}px; height: ${dot.size}px; opacity: ${dot.opacity};`">
                </div>
            </template>
        </div>

        <!-- Hero content -->
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <p class="hero-subtitle">
                    <?= htmlspecialchars($subtitle) ?>
                </p>
            </div>

            <div class="hero-actions">
                <div class="action-buttons">
                    <a href="<?= htmlspecialchars($primaryButton['url']) ?>" class="btn btn-primary">
                        <?= htmlspecialchars($primaryButton['text']) ?>
                    </a>
                    <a href="<?= htmlspecialchars($secondaryButton['url']) ?>" class="btn btn-secondary">
                        <?= htmlspecialchars($secondaryButton['text']) ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative elements -->
        <div class="hero-decoration">
            <div class="decoration-left">
                <div class="brand-text">Boson</div>
                <div class="sub-text">PHP Desktop</div>
            </div>
            <div class="decoration-right">
                <!-- Additional decorative elements -->
            </div>
        </div>
    </section>
<?php endif; ?>

<style>
/* Tailwind animations */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Alpine.js hero styles (existing) */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-bg, #0d1119);
    overflow: hidden;
}

.dots-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.floating-dot {
    position: absolute;
    background: var(--color-text-brand, #7a1a1a);
    border-radius: 50%;
    transition: all 3s ease-in-out;
}

.hero-content {
    text-align: center;
    z-index: 2;
    max-width: 1200px;
    padding: 2rem;
}

.hero-title {
    font-size: clamp(2.5rem, 8vw, 6rem);
    font-weight: 700;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    margin-bottom: 1.5rem;
    line-height: 1.1;
}

.hero-subtitle {
    font-size: clamp(1.125rem, 3vw, 1.5rem);
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    margin-bottom: 3rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.action-buttons {
    display: flex;
    gap: 2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-primary {
    background: var(--color-text-brand, #7a1a1a);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(122, 26, 26, 0.3);
}

.btn-secondary {
    background: transparent;
    color: var(--color-text-brand, #7a1a1a);
    border: 2px solid var(--color-text-brand, #7a1a1a);
}

.btn-secondary:hover {
    background: var(--color-text-brand, #7a1a1a);
    color: white;
}
</style>
