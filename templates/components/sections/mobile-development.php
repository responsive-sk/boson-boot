<?php
/**
 * Mobile Development Section - Rich API showcase
 */
?>

<section class="mobile-development-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Rich API</div>
            <h3>Expanding the boundaries of<br />standard capabilities</h3>
            <p>Boson provides not only the ability to create desktop applications, but also a variety of rich APIs for accessing PC subsystems.</p>
        </div>
        
        <div class="api-showcase">
            <div class="api-categories">
                <div class="api-category" 
                     x-data="{ active: false }"
                     @mouseenter="active = true"
                     @mouseleave="active = false">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                            <path d="M9 9L15 15M15 9L9 15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>System Integration</h4>
                    <ul x-show="active" x-transition>
                        <li>File System Access</li>
                        <li>Registry Management</li>
                        <li>Process Control</li>
                        <li>Environment Variables</li>
                    </ul>
                </div>
                
                <div class="api-category"
                     x-data="{ active: false }"
                     @mouseenter="active = true"
                     @mouseleave="active = false">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>Hardware Access</h4>
                    <ul x-show="active" x-transition>
                        <li>Camera & Microphone</li>
                        <li>USB Devices</li>
                        <li>Serial Ports</li>
                        <li>Bluetooth</li>
                    </ul>
                </div>
                
                <div class="api-category"
                     x-data="{ active: false }"
                     @mouseenter="active = true"
                     @mouseleave="active = false">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>UI Components</h4>
                    <ul x-show="active" x-transition>
                        <li>Native Dialogs</li>
                        <li>System Tray</li>
                        <li>Notifications</li>
                        <li>Menu Bar</li>
                    </ul>
                </div>
                
                <div class="api-category"
                     x-data="{ active: false }"
                     @mouseenter="active = true"
                     @mouseleave="active = false">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <path d="M21 16V8A2 2 0 0019 6H5A2 2 0 003 8V16A2 2 0 005 18H19A2 2 0 0021 16Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M7 10L12 13L17 10" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>Network & Security</h4>
                    <ul x-show="active" x-transition>
                        <li>HTTP/HTTPS Clients</li>
                        <li>WebSocket Support</li>
                        <li>Encryption APIs</li>
                        <li>Certificate Management</li>
                    </ul>
                </div>
            </div>
            
            <div class="code-example">
                <div class="code-header">
                    <span>Example: System Integration</span>
                </div>
                <pre><code>&lt;?php
// Access system information
$system = Boson\System::info();
echo "OS: " . $system->platform();
echo "Memory: " . $system->memory();

// File system operations
$fs = Boson\FileSystem::create();
$files = $fs->listDirectory('/home/user');

// Native notifications
Boson\Notification::show([
    'title' => 'Task Complete',
    'body' => 'Your file has been processed',
    'icon' => '/path/to/icon.png'
]);
?&gt;</code></pre>
            </div>
        </div>
        
        <div class="api-cta">
            <a href="/docs/latest/api" class="btn btn-outline">Explore Full API Documentation</a>
        </div>
    </div>
</section>

<style>
.mobile-development-section {
    margin: 6rem 0;
    padding: 4rem 0;
}

.mobile-development-section .container {
    max-width: var(--width-max, 1200px);
    width: var(--width-content, 90%);
    margin: 0 auto;
}

.mobile-development-section .section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.mobile-development-section .section-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--color-text-brand, #F93904);
    color: white;
    border-radius: 20px;
    font-size: var(--font-size-small, 0.875rem);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1rem;
}

.mobile-development-section .section-header h3 {
    margin: 1rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-h3, 2rem);
    line-height: 1.2;
}

.mobile-development-section .section-header p {
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    max-width: 600px;
    margin: 0 auto;
}

.mobile-development-section .api-showcase {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    margin-bottom: 3rem;
}

.mobile-development-section .api-categories {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.mobile-development-section .api-category {
    padding: 2rem;
    background: var(--color-bg-layer, #0f131c);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.mobile-development-section .api-category:hover {
    transform: translateY(-4px);
    border-color: var(--color-text-brand, #F93904);
}

.mobile-development-section .category-icon {
    color: var(--color-text-brand, #F93904);
    margin-bottom: 1rem;
}

.mobile-development-section .api-category h4 {
    margin: 0 0 1rem 0;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
    font-size: var(--font-size-h5, 1.25rem);
}

.mobile-development-section .api-category ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-development-section .api-category li {
    padding: 0.25rem 0;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
    font-size: var(--font-size-small, 0.875rem);
}

.mobile-development-section .code-example {
    background: var(--color-bg, #0d1119);
    border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));
    border-radius: 12px;
    overflow: hidden;
}

.mobile-development-section .code-header {
    padding: 1rem;
    background: var(--color-bg-hover, rgba(158, 174, 242, 0.1));
    font-size: var(--font-size-small, 0.875rem);
    font-weight: 500;
    color: var(--color-text, rgba(255, 255, 255, 0.9));
}

.mobile-development-section .code-example pre {
    margin: 0;
    padding: 2rem;
    background: var(--color-bg, #0d1119);
    overflow-x: auto;
}

.mobile-development-section .code-example code {
    font-family: var(--font-mono, monospace);
    font-size: var(--font-size-small, 0.875rem);
    line-height: 1.6;
    color: var(--color-text-secondary, rgba(255, 255, 255, 0.6));
}

.mobile-development-section .api-cta {
    text-align: center;
}

@media (max-width: 768px) {
    .mobile-development-section .api-showcase {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .mobile-development-section .api-categories {
        grid-template-columns: 1fr;
    }
}
</style>
