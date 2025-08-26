<?php
/**
 * Logo Component - converted from Lit boson-logo component
 * Displays the Boson PHP logo with optional floating dots animation
 */

$animated = $animated ?? false;
$size = $size ?? 'default'; // default, small, large
?>

<div class="logo-component <?= $animated ? 'animated' : '' ?> size-<?= $size ?>"
     <?php if ($animated): ?>
     x-data="{ 
         dots: [],
         init() {
             this.createFloatingDots();
             setInterval(() => this.animateDots(), 3000);
         },
         createFloatingDots() {
             for (let i = 0; i < 5; i++) {
                 this.dots.push({
                     x: Math.random() * 100,
                     y: Math.random() * 100,
                     opacity: Math.random() * 0.5 + 0.3
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
     }"
     <?php endif; ?>
>
    <!-- Main logo SVG -->
    <svg class="logo-svg" viewBox="0 0 255 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Boson logo with proper colors -->
        <rect x="10" y="20" width="60" height="60" fill="#F93904" rx="8"/>
        <text x="80" y="45" fill="#ffffff" font-family="system-ui, -apple-system, sans-serif" font-size="24" font-weight="600">
            Boson
        </text>
        <text x="80" y="65" fill="rgba(255,255,255,0.6)" font-family="system-ui, -apple-system, sans-serif" font-size="12">
            PHP Desktop
        </text>
    </svg>

    <!-- Floating dots for animation -->
    <?php if ($animated): ?>
    <template x-for="(dot, index) in dots" :key="index">
        <div class="floating-dot" 
             :style="`left: ${dot.x}%; top: ${dot.y}%; opacity: ${dot.opacity}`">
        </div>
    </template>
    <?php endif; ?>
</div>


