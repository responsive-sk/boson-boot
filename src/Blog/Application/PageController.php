<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\ThemeManager;

class PageController
{
    public function __construct(
        private $templateEngine,
    ) {}

    public function download(array $params = []): string
    {
        return $this->templateEngine->render('pages::download');
    }

    public function about(array $params = []): string
    {
        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'About', 'url' => null],
        ];

        return $this->templateEngine->render('pages::about', [
            'title'        => 'About - Boson PHP',
            'description'  => 'Learn more about Boson PHP and our mission to bring PHP to desktop development.',
            'currentRoute' => 'about',
            'pageTitle'    => 'About Boson PHP',
            'pageSubtitle' => 'Bringing PHP to desktop development',
            'breadcrumbs'  => $breadcrumbs,
            'aboutContent' => $this->renderAboutContent(),
        ]);
    }

    public function contact(array $params = []): string
    {
        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Contact', 'url' => null],
        ];

        return $this->templateEngine->render('pages::contact', [
            'title'        => 'Contact - Boson PHP',
            'description'  => 'Get in touch with the Boson PHP team.',
            'currentRoute' => 'contact',
            'pageTitle'    => 'Contact Us',
            'pageSubtitle' => 'Get in touch with our team',
            'breadcrumbs'  => $breadcrumbs,
            'contactContent' => $this->renderContactContent(),
        ]);
    }

    public function privacy(array $params = []): string
    {
        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Privacy Policy', 'url' => null],
        ];

        return $this->templateEngine->render('pages::privacy', [
            'title'        => 'Privacy Policy - Boson PHP',
            'description'  => 'Our privacy policy and how we handle your data.',
            'currentRoute' => 'privacy',
            'pageTitle'    => 'Privacy Policy',
            'breadcrumbs'  => $breadcrumbs,
            'privacyContent' => $this->renderPrivacyContent(),
        ]);
    }

    public function terms(array $params = []): string
    {
        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Terms of Service', 'url' => null],
        ];

        return $this->templateEngine->render('pages::terms', [
            'title'        => 'Terms of Service - Boson PHP',
            'description'  => 'Terms of service for using Boson PHP.',
            'currentRoute' => 'terms',
            'pageTitle'    => 'Terms of Service',
            'breadcrumbs'  => $breadcrumbs,
            'termsContent' => $this->renderTermsContent(),
        ]);
    }

    private function renderAboutContent(): string
    {
        return '
            <div class="about-content">
                <h2>Our Mission</h2>
                <p>Boson PHP aims to revolutionize desktop application development by bringing the power and simplicity of PHP to native desktop applications.</p>

                <h2>Why Boson PHP?</h2>
                <ul>
                    <li><strong>Familiar Language:</strong> Use PHP, the language you already know and love</li>
                    <li><strong>Cross-Platform:</strong> Build once, run on Windows, macOS, and Linux</li>
                    <li><strong>Native Performance:</strong> Enjoy native performance and OS integration</li>
                    <li><strong>Rich Ecosystem:</strong> Leverage the vast PHP ecosystem and packages</li>
                </ul>

                <h2>The Team</h2>
                <p>Boson PHP is developed by a passionate team of developers who believe in making desktop development accessible to PHP developers worldwide.</p>

                <h2>Open Source</h2>
                <p>Boson PHP is open source and welcomes contributions from the community. Join us in building the future of PHP desktop development.</p>
            </div>
        ';
    }

    private function renderContactContent(): string
    {
        return '
            <div class="contact-content">
                <div class="contact-methods">
                    <div class="contact-method">
                        <h3>Community Support</h3>
                        <p>Join our community for questions, discussions, and support:</p>
                        <ul>
                            <li><a href="https://github.com/boson-php/boson" target="_blank">GitHub Discussions</a></li>
                            <li><a href="https://discord.gg/bosonphp" target="_blank">Discord Server</a></li>
                            <li><a href="https://reddit.com/r/bosonphp" target="_blank">Reddit Community</a></li>
                        </ul>
                    </div>

                    <div class="contact-method">
                        <h3>Bug Reports</h3>
                        <p>Found a bug? Please report it on our GitHub repository:</p>
                        <p><a href="https://github.com/boson-php/boson/issues" target="_blank">Report an Issue</a></p>
                    </div>

                    <div class="contact-method">
                        <h3>Business Inquiries</h3>
                        <p>For business partnerships and enterprise support:</p>
                        <p>Email: <a href="mailto:business@bosonphp.com">business@bosonphp.com</a></p>
                    </div>
                </div>

                <div class="contact-form">
                    <h3>Send us a Message</h3>
                    <form hx-post="/contact" hx-target="#contact-result">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>

                    <div id="contact-result"></div>
                </div>
            </div>
        ';
    }

    private function renderPrivacyContent(): string
    {
        return '
            <div class="privacy-content">
                <p><em>Last updated: August 24, 2024</em></p>

                <h2>Information We Collect</h2>
                <p>We collect information you provide directly to us, such as when you create an account, use our services, or contact us for support.</p>

                <h2>How We Use Your Information</h2>
                <p>We use the information we collect to provide, maintain, and improve our services, communicate with you, and comply with legal obligations.</p>

                <h2>Information Sharing</h2>
                <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

                <h2>Data Security</h2>
                <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

                <h2>Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, please contact us at privacy@bosonphp.com.</p>
            </div>
        ';
    }

    private function renderTermsContent(): string
    {
        return '
            <div class="terms-content">
                <p><em>Last updated: August 24, 2024</em></p>

                <h2>Acceptance of Terms</h2>
                <p>By using Boson PHP, you agree to be bound by these Terms of Service and all applicable laws and regulations.</p>

                <h2>Use License</h2>
                <p>Boson PHP is licensed under the MIT License. You are free to use, modify, and distribute the software in accordance with the license terms.</p>

                <h2>Disclaimer</h2>
                <p>The software is provided "as is" without warranty of any kind. We do not guarantee that the software will be error-free or uninterrupted.</p>

                <h2>Limitations</h2>
                <p>In no event shall Boson PHP or its contributors be liable for any damages arising from the use of this software.</p>

                <h2>Modifications</h2>
                <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting.</p>

                <h2>Contact Information</h2>
                <p>For questions about these Terms of Service, please contact us at legal@bosonphp.com.</p>
            </div>
        ';
    }

    public function test(array $params = []): string
    {
        return '<!DOCTYPE html>
<html>
<head>
    <title>Simple Component Test</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .test-section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .component-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Simple PHP Component Test Layer</h1>
        <p>Testing basic PHP components without JS dependencies.</p>

        <div class="test-section">
            <h2>Button Components</h2>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Primary Button', 'type' => 'primary']) . '
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Secondary Button', 'type' => 'secondary']) . '
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Danger Button', 'type' => 'danger']) . '
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Small Button', 'size' => 'small']) . '
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Large Button', 'size' => 'large']) . '
                ' . $this->renderComponent('ui/button-simple', ['text' => 'Disabled Button', 'disabled' => true]) . '
            </div>
        </div>

        <div class="component-grid">
            <div class="test-section">
                <h2>Card Component</h2>
                ' . $this->renderComponent('ui/card-simple', [
                    'title' => 'Test Card',
                    'content' => '<p>This is a simple card component for testing.</p><p>It has multiple paragraphs and <strong>formatted text</strong>.</p>',
                    'footer' => '<small>Card footer content</small>'
                ]) . '
            </div>

            <div class="test-section">
                <h2>Form Component</h2>
                ' . $this->renderComponent('ui/form-simple', [
                    'title' => 'Contact Form',
                    'action' => '/test-submit'
                ]) . '
            </div>
        </div>

    <script src="/assets/svelte/main.js"></script>
    <script>
        // Enhanced Test Component Manager
        class TestComponentManager {
            constructor() {
                this.components = new Map();
                this.activeComponents = new Set();
                this.uiInitialized = false;
                this.componentsLoaded = false;
                this.init();
            }

            init() {
                // Setup UI immediately
                this.setupUI();

                // Check for Svelte registry periodically
                this.checkForSvelteRegistry();
            }

            checkForSvelteRegistry() {
                if (window.svelteRegistry) {
                    console.log("✅ Svelte registry found!");
                    this.loadSvelteComponents();
                } else {
                    console.log("⏳ Waiting for Svelte registry...");
                    setTimeout(() => this.checkForSvelteRegistry(), 1000);
                }
            }

            loadSvelteComponents() {
                if (this.componentsLoaded) return;

                if (window.svelteRegistry) {
                    const svelteComponents = window.svelteRegistry.listComponents();
                    console.log("Available Svelte components:", svelteComponents);

                    svelteComponents.forEach(name => {
                        const info = window.svelteRegistry.getComponentInfo(name);
                        this.registerComponent(name, {
                            description: info.description,
                            type: "svelte",
                            svelteComponent: info
                        });
                    });

                    this.componentsLoaded = true;
                    console.log("🎯 All Svelte components loaded and registered");
                }
            }

            registerComponent(name, config) {
                this.components.set(name, config);
                console.log("📝 Registered component:", name, config.type || "unknown");

                // Only update UI after a short delay to batch updates
                clearTimeout(this.updateTimeout);
                this.updateTimeout = setTimeout(() => this.updateUI(), 100);
            }

            setupUI() {
                const controls = document.getElementById("component-controls");
                if (controls) {
                    controls.innerHTML = "<h3>Component Controls</h3><p>Waiting for Svelte components...</p>";
                }
                console.log("🎯 Test manager UI ready");
            }

            updateUI() {
                const controls = document.getElementById("component-controls");
                if (!controls) return;

                console.log("🔄 Updating UI with", this.components.size, "components");

                let html = "<h3>Component Controls</h3>";

                if (this.components.size === 0) {
                    html += "<p>No components registered yet. Waiting for Svelte components...</p>";
                } else {
                    html += `<p>Found ${this.components.size} components. Click to activate/deactivate:</p>`;
                    html += "<div style=\\"margin: 10px 0;\\">";
                    this.components.forEach((config, name) => {
                        const isActive = this.activeComponents.has(name);
                        const buttonStyle = `
                            margin: 5px;
                            padding: 8px 12px;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            cursor: pointer;
                            background: ${isActive ? "#007bff" : "#fff"};
                            color: ${isActive ? "#fff" : "#333"};
                            transition: all 0.2s;
                        `;
                        html += `
                            <button onclick="testManager.toggleComponent(\'${name}\')"
                                    style="${buttonStyle}"
                                    title="${config.description}">
                                ${name} ${config.type ? `(${config.type})` : ""}
                            </button>
                        `;
                    });
                    html += "</div>";
                }

                controls.innerHTML = html;
                console.log("✅ UI updated successfully");
            }

            toggleComponent(name) {
                const config = this.components.get(name);
                if (!config) return;

                if (this.activeComponents.has(name)) {
                    this.deactivateComponent(name);
                } else {
                    this.activateComponent(name);
                }

                this.updateUI();
            }

            activateComponent(name) {
                const config = this.components.get(name);
                if (!config) return;

                this.activeComponents.add(name);
                console.log("✅ Activating component:", name);

                const instances = document.getElementById("component-instances");
                if (!instances) return;

                // Create container for this component
                const container = document.createElement("div");
                container.id = `component-${name}`;
                container.style.cssText = `
                    border: 1px solid #ddd;
                    margin: 10px 0;
                    padding: 15px;
                    border-radius: 4px;
                    background: #fafafa;
                `;

                container.innerHTML = `
                    <h4 style="margin: 0 0 10px 0; color: #333;">${name}</h4>
                    <p style="margin: 0 0 10px 0; color: #666; font-size: 14px;">${config.description}</p>
                    <div id="component-content-${name}">Loading ${name}...</div>
                `;

                instances.appendChild(container);

                // Load the actual component
                if (config.type === "svelte" && window.svelteRegistry) {
                    this.loadSvelteComponent(name, `component-content-${name}`);
                }
            }

            deactivateComponent(name) {
                this.activeComponents.delete(name);
                console.log("❌ Deactivating component:", name);

                const element = document.getElementById(`component-${name}`);
                if (element) {
                    element.remove();
                }

                // Cleanup Svelte component
                if (window.svelteRegistry) {
                    window.svelteRegistry.unloadComponent(name);
                }
            }

            loadSvelteComponent(name, targetId) {
                const target = document.getElementById(targetId);
                if (!target || !window.svelteRegistry) return;

                try {
                    // Create a new container for the Svelte component
                    const svelteContainer = document.createElement("div");
                    svelteContainer.className = `svelte-test-${name.toLowerCase()}`;
                    target.innerHTML = "";
                    target.appendChild(svelteContainer);

                    // Load the component through the registry
                    window.svelteRegistry.loadComponent(name, svelteContainer);

                } catch (error) {
                    console.error(`Failed to load Svelte component ${name}:`, error);
                    target.innerHTML = `<p style="color: red;">Error loading ${name}: ${error.message}</p>`;
                }
            }
        }


        <div class="test-section">
            <h2>Component Status</h2>
            <div style="background: #e8f5e8; padding: 15px; border-radius: 4px;">
                <h3 style="margin: 0 0 10px 0; color: #2d5a2d;">✅ Simple PHP Components Working</h3>
                <ul style="margin: 0; color: #2d5a2d;">
                    <li>No JavaScript dependencies</li>
                    <li>Server-side rendered</li>
                    <li>Theme-independent</li>
                    <li>Fast and reliable</li>
                </ul>
            </div>
        </div>

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
</body>
</html>';
    }

    private function renderComponent(string $component, array $data = []): string
    {
        // Extract variables for the component
        extract($data);

        // Start output buffering
        ob_start();

        // Include the component file
        $componentPath = __DIR__ . "/../../../templates/components/{$component}.php";
        if (file_exists($componentPath)) {
            include $componentPath;
        } else {
            echo "<p style=\"color: red;\">Component not found: {$component}</p>";
        }

        // Return the captured output
        return ob_get_clean();
    }
}
