<?php
/**
 * Download Page - matching original mark.responsive.sk structure
 */

$this->layout('layouts::app', [
    'title' => 'Download Boson PHP - Desktop Applications with PHP',
    'description' => 'Download Boson PHP and start building native desktop applications with PHP. Available for Windows, macOS, and Linux.',
    'currentRoute' => 'download',
    'pageTitle' => 'Download Boson PHP',
    'pageSubtitle' => 'Get started with native PHP desktop development',
    'breadcrumbs' => [
        ['text' => 'Home', 'url' => '/'],
        ['text' => 'Download', 'url' => null]
    ]
]);
?>

<?php $this->start('main') ?>
        <div class="download-page">
            <div class="download-hero">
                <h2>Choose Your Platform</h2>
                <p>Boson PHP is available for all major desktop platforms. Choose your operating system to get started.</p>
            </div>

            <div class="download-platforms">
                <div class="platform-card">
                    <div class="platform-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                            <path d="M3 12L21 12M12 3L12 21" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Windows</h3>
                    <p>Windows 10 or later (64-bit)</p>
                    <div class="download-buttons">
                        <a href="#" class="btn btn-primary">Download for Windows</a>
                        <span class="version-info">Version 1.0.0 • 45 MB</span>
                    </div>
                </div>

                <div class="platform-card">
                    <div class="platform-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>macOS</h3>
                    <p>macOS 10.15 or later (Intel & Apple Silicon)</p>
                    <div class="download-buttons">
                        <a href="#" class="btn btn-primary">Download for macOS</a>
                        <span class="version-info">Version 1.0.0 • 42 MB</span>
                    </div>
                </div>

                <div class="platform-card">
                    <div class="platform-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Linux</h3>
                    <p>Ubuntu 18.04+ / Debian 10+ / CentOS 8+</p>
                    <div class="download-buttons">
                        <a href="#" class="btn btn-primary">Download for Linux</a>
                        <span class="version-info">Version 1.0.0 • 38 MB</span>
                    </div>
                </div>
            </div>

            <div class="installation-guide">
                <h2>Quick Installation Guide</h2>
                
                <div class="install-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Download</h3>
                            <p>Download the appropriate installer for your operating system from above.</p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Install</h3>
                            <p>Run the installer and follow the setup wizard. Boson will be installed with all necessary dependencies.</p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Create Your First App</h3>
                            <p>Open terminal and run: <code>boson create my-first-app</code></p>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>Run & Develop</h3>
                            <p>Navigate to your app folder and run: <code>boson serve</code></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="system-requirements">
                <h2>System Requirements</h2>
                
                <div class="requirements-grid">
                    <div class="requirement-section">
                        <h3>Minimum Requirements</h3>
                        <ul>
                            <li>PHP 8.1 or higher</li>
                            <li>2 GB RAM</li>
                            <li>500 MB disk space</li>
                            <li>OpenGL 3.3 support</li>
                        </ul>
                    </div>

                    <div class="requirement-section">
                        <h3>Recommended</h3>
                        <ul>
                            <li>PHP 8.2 or higher</li>
                            <li>4 GB RAM or more</li>
                            <li>1 GB disk space</li>
                            <li>Dedicated graphics card</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="alternative-installs">
                <h2>Alternative Installation Methods</h2>
                
                <div class="install-method">
                    <h3>Package Managers</h3>
                    <div class="code-block">
                        <h4>Homebrew (macOS)</h4>
                        <pre><code>brew install boson-php</code></pre>
                        
                        <h4>Chocolatey (Windows)</h4>
                        <pre><code>choco install boson-php</code></pre>
                        
                        <h4>APT (Ubuntu/Debian)</h4>
                        <pre><code>sudo apt install boson-php</code></pre>
                    </div>
                </div>

                <div class="install-method">
                    <h3>Docker</h3>
                    <div class="code-block">
                        <pre><code>docker pull bosonphp/boson:latest
docker run -it bosonphp/boson</code></pre>
                    </div>
                </div>
            </div>

            <div class="help-section">
                <h2>Need Help?</h2>
                <p>If you encounter any issues during installation, check out our:</p>
                <div class="help-links">
                    <a href="/docs/latest/installation" class="btn btn-outline">Installation Guide</a>
                    <a href="/docs/latest/troubleshooting" class="btn btn-outline">Troubleshooting</a>
                    <a href="/community" class="btn btn-outline">Community Support</a>
                </div>
            </div>
        </div>

<?php $this->stop() ?>
