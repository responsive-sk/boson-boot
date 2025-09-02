<?php
/**
 * SVG Dots Pattern Component
 * Creates decorative dot patterns using SVG rect elements
 * 
 * @param string $color - Dot color (hex without #, default: 'F93904')
 * @param int $size - Dot size in pixels (default: 2)
 * @param int $spacing - Spacing between dots (default: 8)
 * @param float $opacity - Pattern opacity (default: 0.05)
 * @param string $position - CSS position: 'absolute', 'fixed', 'relative' (default: 'absolute')
 * @param string $className - Additional CSS class name
 */

$color = $color ?? 'd63031';
$size = $size ?? 2;
$spacing = $spacing ?? 8;
$opacity = $opacity ?? 0.05;
$position = $position ?? 'absolute';
$className = $className ?? '';

// Calculate center position for dot
$center = ($spacing - $size) / 2;

// Create SVG data URL
$svgPattern = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='{$spacing}' height='{$spacing}' viewBox='0 0 {$spacing} {$spacing}'%3E%3Crect width='{$size}' height='{$size}' x='{$center}' y='{$center}' fill='%23{$color}'/%3E%3C/svg%3E";

$uniqueId = 'dots-pattern-' . uniqid();
?>

<div class="svg-dots-pattern <?= $className ?>" id="<?= $uniqueId ?>"></div>

<style>
#<?= $uniqueId ?> {
    position: <?= $position ?>;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("<?= $svgPattern ?>");
    background-repeat: repeat;
    opacity: <?= $opacity ?>;
    pointer-events: none;
    z-index: 1;
}

/* Animation variants */
.svg-dots-pattern.animate-pulse {
    animation: dots-pulse 3s ease-in-out infinite;
}

.svg-dots-pattern.animate-fade {
    animation: dots-fade 2s ease-in-out infinite alternate;
}

.svg-dots-pattern.animate-scale {
    animation: dots-scale 4s ease-in-out infinite;
}

.svg-dots-pattern.animate-rotate {
    animation: dots-rotate 10s linear infinite;
}

/* Hover effects */
.svg-dots-pattern.hover-brighten:hover {
    opacity: <?= min($opacity * 2, 0.2) ?>;
    transition: opacity 0.3s ease;
}

.svg-dots-pattern.hover-scale:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Keyframe animations */
@keyframes dots-pulse {
    0%, 100% { 
        opacity: <?= $opacity ?>; 
        transform: scale(1);
    }
    50% { 
        opacity: <?= min($opacity * 3, 0.3) ?>; 
        transform: scale(1.05);
    }
}

@keyframes dots-fade {
    0% { 
        opacity: <?= $opacity ?>; 
    }
    100% { 
        opacity: <?= min($opacity * 2.5, 0.25) ?>; 
    }
}

@keyframes dots-scale {
    0%, 100% { 
        transform: scale(1); 
    }
    25% { 
        transform: scale(1.02); 
    }
    75% { 
        transform: scale(0.98); 
    }
}

@keyframes dots-rotate {
    0% { 
        transform: rotate(0deg); 
    }
    100% { 
        transform: rotate(360deg); 
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #<?= $uniqueId ?> {
        opacity: <?= max($opacity * 0.7, 0.02) ?>;
    }
}

/* Accessibility - respect reduced motion */
@media (prefers-reduced-motion: reduce) {
    .svg-dots-pattern {
        animation: none !important;
        transition: none !important;
    }
}

/* Color variants */
.svg-dots-pattern.variant-primary {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='<?= $spacing ?>' height='<?= $spacing ?>' viewBox='0 0 <?= $spacing ?> <?= $spacing ?>'%3E%3Crect width='<?= $size ?>' height='<?= $size ?>' x='<?= $center ?>' y='<?= $center ?>' fill='%23d63031'/%3E%3C/svg%3E");
}

.svg-dots-pattern.variant-secondary {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='<?= $spacing ?>' height='<?= $spacing ?>' viewBox='0 0 <?= $spacing ?> <?= $spacing ?>'%3E%3Crect width='<?= $size ?>' height='<?= $size ?>' x='<?= $center ?>' y='<?= $center ?>' fill='%236366f1'/%3E%3C/svg%3E");
}

.svg-dots-pattern.variant-dark {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='<?= $spacing ?>' height='<?= $spacing ?>' viewBox='0 0 <?= $spacing ?> <?= $spacing ?>'%3E%3Crect width='<?= $size ?>' height='<?= $size ?>' x='<?= $center ?>' y='<?= $center ?>' fill='%23272c3a'/%3E%3C/svg%3E");
}

.svg-dots-pattern.variant-light {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='<?= $spacing ?>' height='<?= $spacing ?>' viewBox='0 0 <?= $spacing ?> <?= $spacing ?>'%3E%3Crect width='<?= $size ?>' height='<?= $size ?>' x='<?= $center ?>' y='<?= $center ?>' fill='%23e5e7eb'/%3E%3C/svg%3E");
}

/* Size variants */
.svg-dots-pattern.size-small {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='6' height='6' viewBox='0 0 6 6'%3E%3Crect width='1' height='1' x='2.5' y='2.5' fill='%23<?= $color ?>'/%3E%3C/svg%3E");
}

.svg-dots-pattern.size-large {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Crect width='3' height='3' x='4.5' y='4.5' fill='%23<?= $color ?>'/%3E%3C/svg%3E");
}

/* Density variants */
.svg-dots-pattern.density-sparse {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Crect width='<?= $size ?>' height='<?= $size ?>' x='7' y='7' fill='%23<?= $color ?>'/%3E%3C/svg%3E");
}

.svg-dots-pattern.density-dense {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Crect width='1' height='1' x='1.5' y='1.5' fill='%23<?= $color ?>'/%3E%3C/svg%3E");
}
</style>

<script>
// Auto-trigger animations when element comes into view
document.addEventListener('DOMContentLoaded', function() {
    const dotsPattern = document.getElementById('<?= $uniqueId ?>');
    
    if (dotsPattern && dotsPattern.classList.contains('animate-on-scroll')) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-pulse');
                } else {
                    entry.target.classList.remove('animate-pulse');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        observer.observe(dotsPattern);
    }
});
</script>
