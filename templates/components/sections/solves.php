<?php
/**
 * Solves Section - visual representation of what Boson solves
 */
?>

<section class="solves-section">
    <div class="container">
        <div class="visual-content">
            <div class="problem-solution">
                <div class="problem">
                    <h4>Traditional Web Development</h4>
                    <div class="stack">
                        <div class="layer browser">Browser</div>
                        <div class="layer server">Web Server</div>
                        <div class="layer php">PHP Application</div>
                    </div>
                    <div class="limitations">
                        <span>• Requires browser</span>
                        <span>• Server dependency</span>
                        <span>• Limited OS access</span>
                    </div>
                </div>
                
                <div class="arrow">
                    <svg width="80" height="40" viewBox="0 0 80 40" fill="none">
                        <path d="M10 20H65M65 20L55 10M65 20L55 30" stroke="var(--color-text-brand)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <div class="solution">
                    <h4>Boson PHP Desktop</h4>
                    <div class="stack">
                        <div class="layer native">Native Desktop App</div>
                        <div class="layer php">PHP Application</div>
                    </div>
                    <div class="benefits">
                        <span>• No browser needed</span>
                        <span>• Standalone application</span>
                        <span>• Full OS integration</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.solves-section {
    margin: 6rem 0;
    padding: 4rem 0;
    background: var(--color-bg-layer, #0f131c);
}

.solves-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.solves-section .visual-content {
    display: flex;
    justify-content: center;
    align-items: center;
}

.solves-section .problem-solution {
    display: flex;
    align-items: center;
    gap: 4rem;
    width: 100%;
    justify-content: space-between;
}

.solves-section .problem,
.solves-section .solution {
    flex: 1;
    text-align: center;
}

.solves-section .problem h4,
.solves-section .solution h4 {
    margin-bottom: 2rem;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-h5, 1.25rem);
}

.solves-section .stack {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.solves-section .layer {
    padding: 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.3s ease;
}

.solves-section .layer.browser {
    background: #4285f4;
    color: white;
}

.solves-section .layer.server {
    background: #34a853;
    color: white;
}

.solves-section .layer.php {
    background: var(--color-text-brand, #b02425);
    color: white;
}

.solves-section .layer.native {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.solves-section .layer:hover {
    transform: translateY(-2px);
}

.solves-section .limitations,
.solves-section .benefits {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    font-size: var(--font-size-small, 0.875rem);
}

.solves-section .limitations span {
    color: #ff6b6b;
}

.solves-section .benefits span {
    color: #51cf66;
}

.solves-section .arrow {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.solves-section .arrow svg {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.1);
    }
}

@media (max-width: 768px) {
    .solves-section .problem-solution {
        flex-direction: column;
        gap: 2rem;
    }
    
    .solves-section .arrow {
        transform: rotate(90deg);
    }
}
</style>
