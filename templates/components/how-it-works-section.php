<?php
/**
 * How It Works Section - technical comparison visual
 */
?>

<section class="how-it-works-section">
    <div class="container">
        <div class="comparison">
            <div class="comparison-item electron">
                <h4>Electron Apps</h4>
                <div class="architecture">
                    <div class="layer heavy">Chromium Browser</div>
                    <div class="layer heavy">Node.js Runtime</div>
                    <div class="layer">Your App</div>
                </div>
                <div class="stats">
                    <span class="stat bad">~150MB+ Size</span>
                    <span class="stat bad">High Memory Usage</span>
                    <span class="stat bad">Slow Startup</span>
                </div>
            </div>
            
            <div class="vs">VS</div>
            
            <div class="comparison-item boson">
                <h4>Boson PHP</h4>
                <div class="architecture">
                    <div class="layer light">Native Runtime</div>
                    <div class="layer">Your PHP App</div>
                </div>
                <div class="stats">
                    <span class="stat good">~40MB Size</span>
                    <span class="stat good">Low Memory Usage</span>
                    <span class="stat good">Fast Startup</span>
                </div>
            </div>
        </div>
        
        <div class="tech-stack">
            <h4>Boson Technology Stack</h4>
            <div class="stack-items">
                <div class="stack-item">
                    <div class="icon">⚡</div>
                    <h5>Native Performance</h5>
                    <p>Direct system calls without browser overhead</p>
                </div>
                <div class="stack-item">
                    <div class="icon">🔧</div>
                    <h5>Modern PHP</h5>
                    <p>PHP 8+ with all modern features and performance</p>
                </div>
                <div class="stack-item">
                    <div class="icon">🎯</div>
                    <h5>Cross-Platform</h5>
                    <p>Single codebase for Windows, macOS, and Linux</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.how-it-works-section {
    margin: 6rem 0;
    padding: 4rem 0;
}

.how-it-works-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.how-it-works-section .comparison {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 4rem;
}

.how-it-works-section .comparison-item {
    flex: 1;
    text-align: center;
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
}

.how-it-works-section .comparison-item.electron {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 107, 107, 0.05) 100%);
}

.how-it-works-section .comparison-item.boson {
    background: linear-gradient(135deg, rgba(81, 207, 102, 0.1) 0%, rgba(81, 207, 102, 0.05) 100%);
}

.how-it-works-section .comparison-item h4 {
    margin-bottom: 1.5rem;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.how-it-works-section .architecture {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.how-it-works-section .layer {
    padding: 0.75rem;
    border-radius: 6px;
    font-size: var(--font-size-small, 0.875rem);
    font-weight: 500;
}

.how-it-works-section .layer.heavy {
    background: rgba(255, 107, 107, 0.2);
    color: #ff6b6b;
}

.how-it-works-section .layer.light {
    background: rgba(81, 207, 102, 0.2);
    color: #51cf66;
}

.how-it-works-section .layer:not(.heavy):not(.light) {
    background: var(--color-bg-layer, #0f131c);
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.how-it-works-section .stats {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.how-it-works-section .stat {
    font-size: var(--font-size-small, 0.875rem);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.how-it-works-section .stat.bad {
    background: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.how-it-works-section .stat.good {
    background: rgba(81, 207, 102, 0.1);
    color: #51cf66;
}

.how-it-works-section .vs {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text-brand, #F93904);
    flex-shrink: 0;
}

.how-it-works-section .tech-stack {
    text-align: center;
}

.how-it-works-section .tech-stack h4 {
    margin-bottom: 2rem;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.how-it-works-section .stack-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.how-it-works-section .stack-item {
    padding: 2rem;
    background: var(--color-bg-layer, #0f131c);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.how-it-works-section .stack-item:hover {
    transform: translateY(-4px);
}

.how-it-works-section .stack-item .icon {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.how-it-works-section .stack-item h5 {
    margin: 0 0 1rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.how-it-works-section .stack-item p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
}

@media (max-width: 768px) {
    .how-it-works-section .comparison {
        flex-direction: column;
    }
    
    .how-it-works-section .vs {
        transform: rotate(90deg);
    }
    
    .how-it-works-section .stack-items {
        grid-template-columns: 1fr;
    }
}
</style>
