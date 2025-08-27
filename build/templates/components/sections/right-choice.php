<?php
/**
 * Right Choice Section - why choose Boson
 */
?>

<section class="right-choice-section">
    <div class="container">
        <div class="choice-content">
            <div class="choice-header">
                <h3>Why Boson is the Right Choice</h3>
                <p>Compare Boson with other desktop development solutions</p>
            </div>
            
            <div class="comparison-table">
                <div class="table-header">
                    <div class="feature-col">Feature</div>
                    <div class="solution-col">Electron</div>
                    <div class="solution-col">Tauri</div>
                    <div class="solution-col boson">Boson PHP</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Bundle Size</div>
                    <div class="value bad">150MB+</div>
                    <div class="value good">15MB</div>
                    <div class="value best">40MB</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Memory Usage</div>
                    <div class="value bad">High</div>
                    <div class="value good">Low</div>
                    <div class="value best">Very Low</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Startup Time</div>
                    <div class="value bad">Slow</div>
                    <div class="value good">Fast</div>
                    <div class="value best">Instant</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Language</div>
                    <div class="value neutral">JavaScript</div>
                    <div class="value neutral">Rust</div>
                    <div class="value best">PHP</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Learning Curve</div>
                    <div class="value good">Easy</div>
                    <div class="value bad">Hard</div>
                    <div class="value best">None</div>
                </div>
                
                <div class="table-row">
                    <div class="feature">Ecosystem</div>
                    <div class="value good">Large</div>
                    <div class="value neutral">Growing</div>
                    <div class="value best">Huge</div>
                </div>
            </div>
            
            <div class="choice-benefits">
                <div class="benefit">
                    <div class="benefit-icon">🚀</div>
                    <h4>Familiar Technology</h4>
                    <p>Use PHP skills you already have. No need to learn new languages or frameworks.</p>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">⚡</div>
                    <h4>Superior Performance</h4>
                    <p>Native performance without the overhead of browser engines or heavy runtimes.</p>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">🔧</div>
                    <h4>Rich Ecosystem</h4>
                    <p>Access to thousands of PHP packages and libraries through Composer.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.right-choice-section {
    margin: 6rem 0;
    padding: 4rem 0;
    background: var(--color-bg-layer, #0f131c);
}

.right-choice-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.right-choice-section .choice-header {
    text-align: center;
    margin-bottom: 3rem;
}

.right-choice-section .choice-header h3 {
    margin-bottom: 1rem;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-h3, 2rem);
}

.right-choice-section .choice-header p {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
}

.right-choice-section .comparison-table {
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 3rem;
}

.right-choice-section .table-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    background: var(--color-bg-hover, rgba(158, 174, 242, 0.1));
    font-weight: 600;
}

.right-choice-section .table-header > div {
    padding: 1rem;
    text-align: center;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.right-choice-section .table-header .boson {
    background: var(--color-text-brand, #F93904);
    color: white;
}

.right-choice-section .table-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    border-top: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
}

.right-choice-section .table-row > div {
    padding: 1rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.right-choice-section .feature {
    text-align: left !important;
    justify-content: flex-start !important;
    font-weight: 500;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.right-choice-section .value {
    font-size: var(--font-size-small, 0.875rem);
    padding: 0.5rem;
    border-radius: 4px;
    font-weight: 500;
}

.right-choice-section .value.bad {
    background: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.right-choice-section .value.good {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.right-choice-section .value.best {
    background: rgba(81, 207, 102, 0.1);
    color: #51cf66;
}

.right-choice-section .value.neutral {
    background: var(--color-bg-layer, #0f131c);
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
}

.right-choice-section .choice-benefits {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.right-choice-section .benefit {
    text-align: center;
    padding: 2rem;
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.right-choice-section .benefit:hover {
    transform: translateY(-4px);
}

.right-choice-section .benefit-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.right-choice-section .benefit h4 {
    margin: 0 0 1rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.right-choice-section .benefit p {
    margin: 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
}

@media (max-width: 768px) {
    .right-choice-section .table-header,
    .right-choice-section .table-row {
        grid-template-columns: 1fr;
    }
    
    .right-choice-section .table-header > div,
    .right-choice-section .table-row > div {
        text-align: left;
        justify-content: flex-start;
    }
    
    .right-choice-section .choice-benefits {
        grid-template-columns: 1fr;
    }
}
</style>
