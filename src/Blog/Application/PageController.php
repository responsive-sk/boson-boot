<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\Templating\ThemeManager;

class PageController
{
    public function __construct(
        private $templateEngine,
        private ThemeManager $themeManager
    ) {}

    public function download(array $params = []): string
    {
        return $this->templateEngine->render('pages::download', [
            'themeManager' => $this->themeManager
        ]);
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
            'themeManager' => $this->themeManager,
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
            'themeManager' => $this->themeManager,
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
            'themeManager' => $this->themeManager,
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
            'themeManager' => $this->themeManager,
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
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Components', 'url' => '/test'],
            ['label' => 'Test']
        ];

        $filters = [
            ['label' => 'All Components', 'url' => '/test', 'active' => true, 'count' => 12],
            ['label' => 'Buttons', 'url' => '/test?filter=buttons', 'count' => 6],
            ['label' => 'Cards', 'url' => '/test?filter=cards', 'count' => 3],
            ['label' => 'Forms', 'url' => '/test?filter=forms', 'count' => 2],
            ['label' => 'Headlines', 'url' => '/test?filter=headlines', 'count' => 4]
        ];

        return $this->templateEngine->render('pages::test', [
            'title' => 'Component Test - Boson PHP',
            'description' => 'Testing PHP components with optimal performance',
            'currentRoute' => 'test',
            'pageTitle' => 'Component Test',
            'pageSubtitle' => 'Testing basic PHP components without JS dependencies',
            'breadcrumbs' => $breadcrumbs,
            'filters' => $filters,
            'background' => 'subtle', // Nice gradient with subtle dots
            'themeManager' => $this->themeManager,
        ]);
    }

    // Removed old test method with embedded HTML - that was a terrible anti-pattern!
    // HTML belongs in templates, not controllers!

    // All HTML content has been moved to templates/pages/test.php where it belongs!
}
