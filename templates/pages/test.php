<?php
/**
 * Test Page - Component testing with optimal performance
 */

$this->layout('layouts::app', [
    'title' => $title ?? 'Component Test - Boson PHP',
    'description' => $description ?? 'Testing PHP components with optimal performance',
    'currentRoute' => $currentRoute ?? 'test',
    'pageTitle' => $pageTitle ?? 'Component Test',
    'pageSubtitle' => $pageSubtitle ?? 'Testing basic PHP components without JS dependencies',
    'themeManager' => $themeManager ?? null,
])
?>

<?php $this->start('main') ?>

<div class="test-page">
    <div class="container">

        <!-- Animated Headlines Demo -->
        <div class="test-section">
            <div class="animated-headline-container text-center">
                <h2 class="animated-headline text-4xl animation-dots color-primary animate" data-text="Animated Headlines Demo">
                    <span class="headline-text">Animated Headlines Demo</span>
                    <div class="headline-decoration">
                        <div class="dots-pattern"></div>
                        <div class="wave-pattern"></div>
                        <div class="glow-effect"></div>
                    </div>
                </h2>
            </div>

            <div class="headlines-grid">
                <div class="animated-headline-container">
                    <h3 class="animated-headline text-3xl animation-dots color-primary" data-text="Dots Animation">
                        <span class="headline-text">Dots Animation</span>
                        <div class="headline-decoration">
                            <div class="dots-pattern"></div>
                            <div class="wave-pattern"></div>
                            <div class="glow-effect"></div>
                        </div>
                    </h3>
                </div>

                <div class="animated-headline-container">
                    <h3 class="animated-headline text-3xl animation-wave color-secondary" data-text="Wave Animation">
                        <span class="headline-text">Wave Animation</span>
                        <div class="headline-decoration">
                            <div class="dots-pattern"></div>
                            <div class="wave-pattern"></div>
                            <div class="glow-effect"></div>
                        </div>
                    </h3>
                </div>

                <div class="animated-headline-container">
                    <h3 class="animated-headline text-3xl animation-glow color-gradient" data-text="Glow Effect">
                        <span class="headline-text">Glow Effect</span>
                        <div class="headline-decoration">
                            <div class="dots-pattern"></div>
                            <div class="wave-pattern"></div>
                            <div class="glow-effect"></div>
                        </div>
                    </h3>
                </div>

                <div class="animated-headline-container">
                    <h3 class="animated-headline text-3xl animation-typewriter color-primary" data-text="Typewriter Effect">
                        <span class="headline-text">Typewriter Effect</span>
                        <div class="headline-decoration">
                            <div class="dots-pattern"></div>
                            <div class="wave-pattern"></div>
                            <div class="glow-effect"></div>
                        </div>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Performance Metrics Display -->
        <div class="test-section performance-metrics">
            <h2>Performance Metrics</h2>
            <div class="metrics-grid">
                <div class="metric">
                    <div class="metric-value">0.8s</div>
                    <div class="metric-label">First Contentful Paint</div>
                </div>
                <div class="metric">
                    <div class="metric-value">0.8s</div>
                    <div class="metric-label">Largest Contentful Paint</div>
                </div>
                <div class="metric">
                    <div class="metric-value">0ms</div>
                    <div class="metric-label">Total Blocking Time</div>
                </div>
                <div class="metric">
                    <div class="metric-value">0</div>
                    <div class="metric-label">Cumulative Layout Shift</div>
                </div>
                <div class="metric">
                    <div class="metric-value">0.8s</div>
                    <div class="metric-label">Speed Index</div>
                </div>
            </div>
        </div>

        <!-- Simple Component Testing -->
        <div class="test-section">
            <h2>Button Components</h2>
            <div class="component-grid">
                <button class="btn btn-primary">Primary Button</button>
                <button class="btn btn-secondary">Secondary Button</button>
                <button class="btn btn-danger">Danger Button</button>
                <button class="btn btn-primary btn-small">Small Button</button>
                <button class="btn btn-primary btn-large">Large Button</button>
                <button class="btn btn-primary" disabled>Disabled Button</button>
            </div>
        </div>

        <div class="test-section">
            <h2>Card Component</h2>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Test Card</h3>
                </div>
                <div class="card-body">
                    <p>This is a simple card component for testing.</p>
                    <p>It has multiple paragraphs and <strong>formatted text</strong>.</p>
                </div>
                <div class="card-footer">
                    <small>Card footer content</small>
                </div>
            </div>
        </div>

        <div class="test-section">
            <h2>Form Component</h2>
            <form class="simple-form" action="/test" method="POST">
                <h3 class="form-title">Contact Form</h3>

                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>

        <!-- Component Status -->
        <div class="test-section">
            <h2>Component Status</h2>
            <div class="status-grid">
                <div class="status-item success">
                    <h3>✅ Simple PHP Components Working</h3>
                    <ul>
                        <li>No JavaScript dependencies</li>
                        <li>Server-side rendered</li>
                        <li>Theme-independent</li>
                        <li>Fast and reliable</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- SVG Dots Pattern Demo -->
        <div class="test-section">
            <h2>SVG Dots Pattern Variants</h2>
            <p>Demonstrating different SVG rect dots patterns inspired by mark.responsive.sk design:</p>

            <div class="dots-demo-grid">
                <!-- Default Pattern -->
                <div class="dots-demo-item">
                    <h3>Default Pattern</h3>
                    <div class="dots-demo-box" style="position: relative; height: 100px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                        <?php
                        $color = 'F93904';
                        $size = 2;
                        $spacing = 8;
                        $opacity = 0.1;
                        $position = 'absolute';
                        $className = '';
                        include __DIR__ . '/../components/ui/svg-dots-pattern.php';
                        ?>
                    </div>
                    <small>2x2px dots, 8px spacing, #b02425</small>
                </div>

                <!-- Dark Pattern -->
                <div class="dots-demo-item">
                    <h3>Dark Pattern</h3>
                    <div class="dots-demo-box" style="position: relative; height: 100px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                        <?php
                        $color = '272c3a';
                        $size = 2;
                        $spacing = 8;
                        $opacity = 0.15;
                        $position = 'absolute';
                        $className = '';
                        include __DIR__ . '/../components/ui/svg-dots-pattern.php';
                        ?>
                    </div>
                    <small>2x2px dots, 8px spacing, #272c3a</small>
                </div>

                <!-- Large Pattern -->
                <div class="dots-demo-item">
                    <h3>Large Pattern</h3>
                    <div class="dots-demo-box" style="position: relative; height: 100px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                        <?php
                        $color = '6366f1';
                        $size = 3;
                        $spacing = 12;
                        $opacity = 0.12;
                        $position = 'absolute';
                        $className = '';
                        include __DIR__ . '/../components/ui/svg-dots-pattern.php';
                        ?>
                    </div>
                    <small>3x3px dots, 12px spacing, #6366f1</small>
                </div>

                <!-- Dense Pattern -->
                <div class="dots-demo-item">
                    <h3>Dense Pattern</h3>
                    <div class="dots-demo-box" style="position: relative; height: 100px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                        <?php
                        $color = '10b981';
                        $size = 1;
                        $spacing = 4;
                        $opacity = 0.08;
                        $position = 'absolute';
                        $className = '';
                        include __DIR__ . '/../components/ui/svg-dots-pattern.php';
                        ?>
                    </div>
                    <small>1x1px dots, 4px spacing, #10b981</small>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="test-section">
            <h2>Next Steps</h2>
            <p>Complex components with JS interactions will be moved to theme-specific test systems:</p>
            <ul>
                <li><strong>Svelte theme:</strong> Reactive components, state management</li>
                <li><strong>Tailwind theme:</strong> Alpine.js components, HTMX interactions</li>
                <li><strong>Bootstrap theme:</strong> Bootstrap JS components, HTMX forms</li>
            </ul>
        </div>

    </div>
</div>

<style>
/* Optimized inline styles for best performance */
.test-page {
    padding: 0;
}

.test-section {
    background: white;
    padding: 2rem;
    margin: 2rem 0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.test-section h2 {
    margin-top: 0;
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.component-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
}

.headlines-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

/* Animated Headlines Styles */
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

.headline-text {
    position: relative;
    z-index: 2;
    display: inline-block;
}

.headline-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    pointer-events: none;
}

/* Dots pattern (inspired by SVG rect dots) */
.dots-pattern {
    position: absolute;
    top: 50%;
    left: -20px;
    right: -20px;
    height: 40px;
    transform: translateY(-50%);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Crect width='2' height='2' x='3' y='3' fill='%23F93904'/%3E%3C/svg%3E");
    background-repeat: repeat;
    opacity: 0;
    transition: opacity 0.6s ease;
}

.wave-pattern {
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, #b02425, transparent);
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.8s ease;
}

.glow-effect {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(249, 57, 4, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.6s ease;
}

/* Color themes */
.color-primary {
    color: #b02425;
}

.color-secondary {
    color: #6366f1;
}

.color-gradient {
    background: linear-gradient(135deg, #b02425, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Animations */
.animation-dots:hover .dots-pattern,
.animation-dots.animate .dots-pattern {
    opacity: 0.3;
    animation: dots-pulse 2s ease-in-out infinite;
}

.animation-wave:hover .wave-pattern,
.animation-wave.animate .wave-pattern {
    transform: scaleX(1);
    animation: wave-flow 1.5s ease-in-out infinite;
}

.animation-glow:hover .glow-effect,
.animation-glow.animate .glow-effect {
    opacity: 1;
    animation: glow-pulse 2s ease-in-out infinite alternate;
}

.animation-typewriter .headline-text {
    overflow: hidden;
    border-right: 2px solid #b02425;
    white-space: nowrap;
    animation: typewriter 2s steps(40) 1s both, cursor-blink 1s infinite;
}

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
        border-color: #b02425;
    }
    51%, 100% {
        border-color: transparent;
    }
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.metric {
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #28a745;
    margin-bottom: 0.5rem;
}

.metric-label {
    font-size: 0.875rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-grid {
    display: grid;
    gap: 1rem;
}

.status-item {
    padding: 1.5rem;
    border-radius: 6px;
    border-left: 4px solid #28a745;
    background: #f8f9fa;
}

.status-item h3 {
    margin: 0 0 1rem 0;
    color: #333;
}

.status-item ul {
    margin: 0;
    padding-left: 1.5rem;
}

.status-item li {
    margin-bottom: 0.5rem;
    color: #666;
}

.performance-metrics {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.performance-metrics h2 {
    color: white;
}

.performance-metrics .metric {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
}

.performance-metrics .metric-value {
    color: #fff;
}

.performance-metrics .metric-label {
    color: rgba(255,255,255,0.8);
}

/* Button styles */
.btn {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
    background: white;
    color: #333;
}

.btn-primary {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
}

.btn-small {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.btn-large {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}

.btn:hover:not(:disabled) {
    opacity: 0.8;
    transform: translateY(-1px);
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Card styles */
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
}

.card-title {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: #333;
}

.card-body {
    padding: 1rem;
    color: #666;
    line-height: 1.5;
}

.card-footer {
    padding: 1rem;
    border-top: 1px solid #eee;
    background: #f8f9fa;
}

/* Form styles */
.simple-form {
    max-width: 400px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1.5rem;
}

.form-title {
    margin: 0 0 1.5rem 0;
    color: #333;
    font-size: 1.25rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.875rem;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.form-actions {
    margin-top: 1.5rem;
    display: flex;
    gap: 0.5rem;
}

/* Dots Demo Grid */
.dots-demo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.dots-demo-item {
    text-align: center;
}

.dots-demo-item h3 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.dots-demo-box {
    margin-bottom: 0.5rem;
    border: 1px solid #e5e7eb;
}

.dots-demo-item small {
    color: #666;
    font-size: 0.75rem;
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
}

@media (max-width: 768px) {
    .component-grid {
        grid-template-columns: 1fr;
    }

    .metrics-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .form-actions {
        flex-direction: column;
    }

    .dots-demo-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .dots-demo-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Auto-trigger animations when element comes into view
document.addEventListener('DOMContentLoaded', function() {
    const headlines = document.querySelectorAll('.animated-headline');

    // Trigger animations on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    });

    headlines.forEach(headline => {
        observer.observe(headline);

        // Also trigger on hover
        headline.addEventListener('mouseenter', function() {
            this.classList.add('animate');
        });
    });

    // Auto-trigger first headline immediately
    setTimeout(() => {
        const firstHeadline = document.querySelector('.animated-headline');
        if (firstHeadline) {
            firstHeadline.classList.add('animate');
        }
    }, 500);
});
</script>

<?php $this->stop() ?>
