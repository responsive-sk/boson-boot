<?php
/**
 * Call to Action Section - final CTA
 */
?>

<section class="call-to-action-section">
    <div class="container">
        <div class="cta-content">
            <div class="cta-background">
                <div class="bg-pattern"></div>
            </div>
            
            <div class="cta-text">
                <h2>If you are a PHP developer, you can already<br />
                    make native cross-platform applications.<br />
                    <span class="highlight">Boson PHP makes it possible!</span>
                </h2>
                
                <p>Join thousands of developers who are already building amazing desktop applications with PHP.</p>
                
                <div class="cta-stats">
                    <div class="stat-item">
                        <span class="stat-icon">⚡</span>
                        <span>3x Faster than Electron</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">💾</span>
                        <span>75% Less Memory Usage</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">📦</span>
                        <span>4x Smaller Bundle Size</span>
                    </div>
                </div>
            </div>
            
            <div class="cta-actions">
                <h3 class="cta-subtitle">Get started right now!</h3>
                
                <div class="cta-buttons">
                    <?php $this->insert('components/ui/button', [
                        'href' => '/docs/latest/installation',
                        'text' => 'Try Boson For Free',
                        'type' => 'primary',
                        'size' => 'large'
                    ]) ?>
                    
                    <?php $this->insert('components/ui/button', [
                        'href' => '/download',
                        'text' => 'Download Now',
                        'type' => 'outline',
                        'size' => 'large'
                    ]) ?>
                </div>
                
                <div class="cta-note">
                    <p>Free and open source. No credit card required.</p>
                </div>
            </div>
        </div>
        
        <div class="cta-features">
            <div class="feature-item">
                <div class="feature-icon">🚀</div>
                <div class="feature-text">
                    <h4>Quick Start</h4>
                    <p>Get up and running in minutes with our comprehensive documentation</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🛠️</div>
                <div class="feature-text">
                    <h4>Rich Tooling</h4>
                    <p>Built-in development tools and debugging capabilities</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🌍</div>
                <div class="feature-text">
                    <h4>Global Community</h4>
                    <p>Join developers from around the world building with Boson</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">📚</div>
                <div class="feature-text">
                    <h4>Extensive Docs</h4>
                    <p>Comprehensive guides, tutorials, and API documentation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.call-to-action-section {
    margin: 6rem 0 0 0;
    padding: 6rem 0;
    background: linear-gradient(135deg, var(--color-bg, #0d1119) 0%, var(--color-bg-layer, #0f131c) 100%);
    position: relative;
    overflow: hidden;
}

.call-to-action-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.call-to-action-section .cta-content {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
}

.call-to-action-section .cta-background {
    position: absolute;
    top: -50%;
    left: -50%;
    right: -50%;
    bottom: -50%;
    opacity: 0.1;
    z-index: -1;
}

.call-to-action-section .bg-pattern {
    width: 100%;
    height: 100%;
    background-image: radial-gradient(circle at 25% 25%, var(--color-text-brand, #7a1a1a) 2px, transparent 2px),
                      radial-gradient(circle at 75% 75%, var(--color-text-brand, #7a1a1a) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: float 20s ease-in-out infinite;
}

.call-to-action-section .cta-text h2 {
    font-size: var(--font-size-h2, 2.5rem);
    font-family: var(--font-title);
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.call-to-action-section .highlight {
    color: var(--color-text-brand, #7a1a1a);
}

.call-to-action-section .cta-text p {
    font-size: var(--font-size-large, 1.125rem);
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.call-to-action-section .cta-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.call-to-action-section .stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--color-bg-layer, #0f131c);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 25px;
    font-size: var(--font-size-small, 0.875rem);
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.call-to-action-section .stat-icon {
    font-size: 1.2rem;
}

.call-to-action-section .cta-subtitle {
    color: var(--color-text-brand, #7a1a1a);
    font-size: var(--font-size-h4, 1.5rem);
    font-family: var(--font-title);
    margin: 0 0 2rem 0;
}

.call-to-action-section .cta-buttons {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.call-to-action-section .cta-note p {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
    margin: 0;
}

.call-to-action-section .cta-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 4rem;
}

.call-to-action-section .feature-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.call-to-action-section .feature-item:hover {
    transform: translateY(-4px);
}

.call-to-action-section .feature-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.call-to-action-section .feature-text h4 {
    margin: 0 0 0.5rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-base, 1rem);
}

.call-to-action-section .feature-text p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
    line-height: 1.4;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
    }
}

@media (max-width: 768px) {
    .call-to-action-section .cta-text h2 {
        font-size: var(--font-size-h3, 2rem);
    }
    
    .call-to-action-section .cta-stats {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    
    .call-to-action-section .cta-buttons {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    
    .call-to-action-section .cta-features {
        grid-template-columns: 1fr;
    }
}
</style>
