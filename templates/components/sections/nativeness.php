<?php
/**
 * Nativeness Section - converted from Lit nativeness-section component
 * Visual representation of PHP going native
 */
?>

<section class="nativeness-section">
    <div class="container">
        <div class="content">
            <div class="wtf">
                <div class="edge"></div>
                <div class="half"></div>
                <div class="full">
                    <div class="php-logo">
                        <span>PHP</span>
                    </div>
                </div>
                <div class="half"></div>
                <div class="edge"></div>
            </div>
            
            <div class="arrow-container">
                <svg class="arrow" width="60" height="40" viewBox="0 0 60 40" fill="none">
                    <path d="M5 20H50M50 20L40 10M50 20L40 30" stroke="var(--color-text-brand)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <div class="platforms">
                <div class="platform">
                    <div class="platform-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                            <path d="M9 9L15 15M15 9L9 15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <span>Windows</span>
                </div>
                
                <div class="platform">
                    <div class="platform-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 3C8 3 8 9 12 9S16 3 12 3" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <span>macOS</span>
                </div>
                
                <div class="platform">
                    <div class="platform-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                            <path d="M8 12L12 16L16 12" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <span>Linux</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.nativeness-section {
    margin: 4rem 0;
    /* Prevent layout shift by reserving space */
    min-height: 500px;
    contain: layout; /* CSS containment for better performance */
}

.nativeness-section .container {
    display: flex;
    flex-direction: column;
    margin-bottom: 2em;
}

.nativeness-section .content {
    display: flex;
    justify-content: center;
    align-items: center;
    align-self: stretch;
    flex-direction: column;
    padding-top: 8rem; /* Changed from margin-top to padding-top */
    gap: 3rem;
    min-height: 400px; /* Reserve space to prevent layout shift */
}

.nativeness-section .wtf {
    display: flex;
    align-self: stretch;
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.nativeness-section .edge {
    flex: 3;
    border: none !important;
}

.nativeness-section .full {
    flex: 4;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nativeness-section .half {
    flex: 2;
}

.nativeness-section .wtf > div {
    height: 100px;
    border: 1px dashed var(--color-border, rgba(255, 255, 255, 0.1));
    border-bottom: none;
    /* Remove transition to prevent layout shift */
    /* transition: 0.3s ease-in-out; */
}

.nativeness-section .php-logo {
    background: var(--color-text-brand, #7a1a1a);
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.5rem;
    font-family: var(--font-title);
}

.nativeness-section .arrow-container {
    display: flex;
    justify-content: center;
}

.nativeness-section .arrow {
    animation: bounce 2s infinite;
}

.nativeness-section .platforms {
    display: flex;
    gap: 4rem;
    justify-content: center;
    flex-wrap: wrap;
}

.nativeness-section .platform {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 2rem;
    background: var(--color-bg-layer, #0f131c);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.nativeness-section .platform:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.nativeness-section .platform-icon {
    color: var(--color-text-brand, #7a1a1a);
}

.nativeness-section .platform span {
    font-weight: 500;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

@media (max-width: 768px) {
    .nativeness-section .content {
        margin-top: 4em;
        gap: 2rem;
    }
    
    .nativeness-section .platforms {
        gap: 2rem;
    }
    
    .nativeness-section .platform {
        padding: 1.5rem;
    }
}
</style>
