<?php
/**
 * Animated Headline Component with dots pattern
 * 
 * @param string $text - The headline text
 * @param string $size - Size: 'small', 'medium', 'large', 'xl' (default: 'medium')
 * @param string $animation - Animation type: 'dots', 'wave', 'glow', 'typewriter' (default: 'dots')
 * @param string $color - Color theme: 'primary', 'secondary', 'gradient' (default: 'primary')
 * @param bool $centered - Center align the headline (default: false)
 */

$text = $text ?? 'Animated Headline';
$size = $size ?? 'medium';
$animation = $animation ?? 'dots';
$color = $color ?? 'primary';
$centered = $centered ?? false;

$sizeClasses = [
    'small' => 'text-xl',
    'medium' => 'text-3xl',
    'large' => 'text-4xl',
    'xl' => 'text-5xl'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['medium'];
$centerClass = $centered ? 'text-center' : '';
$uniqueId = 'headline-' . uniqid();
?>

<div class="animated-headline-container <?= $centerClass ?>">
    <h2 id="<?= $uniqueId ?>" class="animated-headline <?= $sizeClass ?> animation-<?= $animation ?> color-<?= $color ?>" data-text="<?= htmlspecialchars($text) ?>">
        <span class="headline-text"><?= htmlspecialchars($text) ?></span>
        <div class="headline-decoration">
            <div class="dots-pattern"></div>
            <div class="wave-pattern"></div>
            <div class="glow-effect"></div>
        </div>
    </h2>
</div>

<style>
.animated-headline-container {
    margin: 2rem 0;
    position: relative;
}

.animated-headline {
    position: relative;
    font-weight: 700;
    line-height: 1.2;
    margin: 0;
    overflow: hidden;
    display: inline-block;
}

/* Size classes */
.text-xl { font-size: 1.25rem; }
.text-3xl { font-size: 1.875rem; }
.text-4xl { font-size: 2.25rem; }
.text-5xl { font-size: 3rem; }

.text-center {
    text-align: center;
    width: 100%;
}

.text-center .animated-headline {
    display: block;
}

/* Headline text */
.headline-text {
    position: relative;
    z-index: 2;
    display: inline-block;
}

/* Decoration container */
.headline-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    pointer-events: none;
}

/* Dots pattern (inspired by dots-inner) */
.dots-pattern {
    position: absolute;
    top: 50%;
    left: -20px;
    right: -20px;
    height: 40px;
    transform: translateY(-50%);
    background: radial-gradient(circle, var(--primary, #7a1a1a) 2px, transparent 2px);
    background-size: 8px 8px;
    opacity: 0;
    transition: opacity 0.6s ease;
}

/* Wave pattern */
.wave-pattern {
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--primary, #7a1a1a), transparent);
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.8s ease;
}

/* Glow effect */
.glow-effect {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(214, 48, 49, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.6s ease;
}

/* Color themes */
.color-primary {
    color: var(--primary, #7a1a1a);
}

.color-secondary {
    color: var(--secondary, #6366f1);
}

.color-gradient {
    background: linear-gradient(135deg, var(--primary, #7a1a1a), var(--secondary, #6366f1));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Animation: Dots */
.animation-dots:hover .dots-pattern,
.animation-dots.animate .dots-pattern {
    opacity: 0.3;
    animation: dots-pulse 2s ease-in-out infinite;
}

.animation-dots:hover .headline-text,
.animation-dots.animate .headline-text {
    animation: text-bounce 0.6s ease-out;
}

/* Animation: Wave */
.animation-wave:hover .wave-pattern,
.animation-wave.animate .wave-pattern {
    transform: scaleX(1);
    animation: wave-flow 1.5s ease-in-out infinite;
}

.animation-wave:hover .headline-text,
.animation-wave.animate .headline-text {
    animation: text-wave 1s ease-in-out;
}

/* Animation: Glow */
.animation-glow:hover .glow-effect,
.animation-glow.animate .glow-effect {
    opacity: 1;
    animation: glow-pulse 2s ease-in-out infinite alternate;
}

.animation-glow:hover .headline-text,
.animation-glow.animate .headline-text {
    text-shadow: 0 0 20px rgba(214, 48, 49, 0.5);
    animation: text-glow 1s ease-out;
}

/* Animation: Typewriter */
.animation-typewriter .headline-text {
    overflow: hidden;
    border-right: 2px solid var(--primary, #7a1a1a);
    white-space: nowrap;
    animation: typewriter 2s steps(40) 1s both, cursor-blink 1s infinite;
}

/* Keyframe animations */
@keyframes dots-pulse {
    0%, 100% { 
        opacity: 0.3; 
        transform: translateY(-50%) scale(1);
    }
    50% { 
        opacity: 0.6; 
        transform: translateY(-50%) scale(1.05);
    }
}

@keyframes wave-flow {
    0%, 100% { 
        background-position: -200% center; 
    }
    50% { 
        background-position: 200% center; 
    }
}

@keyframes glow-pulse {
    0% { 
        opacity: 0.5; 
        filter: blur(5px);
    }
    100% { 
        opacity: 1; 
        filter: blur(10px);
    }
}

@keyframes text-bounce {
    0%, 100% { 
        transform: translateY(0); 
    }
    50% { 
        transform: translateY(-5px); 
    }
}

@keyframes text-wave {
    0%, 100% { 
        transform: translateY(0); 
    }
    25% { 
        transform: translateY(-3px); 
    }
    75% { 
        transform: translateY(3px); 
    }
}

@keyframes text-glow {
    0% {
        text-shadow: 0 0 5px rgba(214, 48, 49, 0.3);
    }
    50% {
        text-shadow: 0 0 20px rgba(214, 48, 49, 0.8), 0 0 30px rgba(214, 48, 49, 0.5);
    }
    100% {
        text-shadow: 0 0 10px rgba(214, 48, 49, 0.5);
    }
}

@keyframes typewriter {
    0% { 
        width: 0; 
    }
    100% { 
        width: 100%; 
    }
}

@keyframes cursor-blink {
    0%, 50% {
        border-color: var(--primary, #7a1a1a);
    }
    51%, 100% {
        border-color: transparent;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .text-5xl { font-size: 2.25rem; }
    .text-4xl { font-size: 1.875rem; }
    .text-3xl { font-size: 1.5rem; }
    
    .dots-pattern {
        left: -10px;
        right: -10px;
        height: 30px;
        background-size: 6px 6px;
    }
}

/* Auto-trigger animations on scroll */
.animated-headline.in-view {
    animation-play-state: running;
}

.animated-headline.in-view .dots-pattern {
    opacity: 0.3;
    animation: dots-pulse 2s ease-in-out infinite;
}

.animated-headline.in-view .wave-pattern {
    transform: scaleX(1);
}

.animated-headline.in-view .glow-effect {
    opacity: 1;
}
</style>

<script>
// Auto-trigger animations when element comes into view
document.addEventListener('DOMContentLoaded', function() {
    const headlines = document.querySelectorAll('.animated-headline');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view', 'animate');
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    });
    
    headlines.forEach(headline => {
        observer.observe(headline);
    });
});
</script>
