<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

class DocsController
{
    public function __construct(
        private $templateEngine,
    ) {}

    public function index(array $params = []): string
    {
        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Documentation', 'url' => null],
        ];

        return $this->templateEngine->render('pages::docs-index', [
            'title'        => 'Documentation - Boson PHP',
            'description'  => 'Complete documentation for Boson PHP desktop development.',
            'currentRoute' => 'docs.index',
            'pageTitle'    => 'Documentation',
            'pageSubtitle' => 'Everything you need to build desktop applications with PHP',
            'breadcrumbs'  => $breadcrumbs,
            'docsContent'  => $this->renderDocsIndex(),
            'sidebar'      => $this->renderDocsSidebar(),
        ]);
    }

    public function version(array $params = []): string
    {
        $version = $params['version'] ?? 'latest';

        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Documentation', 'url' => '/docs'],
            ['text' => ucfirst($version), 'url' => null],
        ];

        return $this->templateEngine->render('pages::docs-version', [
            'title'        => "Documentation {$version} - Boson PHP",
            'description'  => "Boson PHP documentation version {$version}.",
            'currentRoute' => 'docs.version',
            'pageTitle'    => "Documentation - {$version}",
            'pageSubtitle' => 'Choose a topic to get started',
            'breadcrumbs'  => $breadcrumbs,
            'version'      => $version,
            'docsContent'  => $this->renderDocsVersion($version),
            'sidebar'      => $this->renderDocsSidebar($version),
        ]);
    }

    public function show(array $params = []): string
    {
        $version = $params['version'] ?? 'latest';
        $slug    = $params['slug'] ?? '';

        // Mock documentation content
        $doc = $this->getDocumentBySlug($slug);

        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Documentation', 'url' => '/docs'],
            ['text' => ucfirst($version), 'url' => "/docs/{$version}"],
            ['text' => $doc['title'], 'url' => null],
        ];

        return $this->templateEngine->render('pages::docs-article', [
            'title'           => $doc['title'] . ' - Documentation - Boson PHP',
            'description'     => $doc['description'],
            'currentRoute'    => 'docs.show',
            'pageTitle'       => $doc['title'],
            'breadcrumbs'     => $breadcrumbs,
            'doc'             => $doc,
            'version'         => $version,
            'sidebar'         => $this->renderDocsSidebar($version, $slug),
            'tableOfContents' => $doc['toc'] ?? [],
        ]);
    }

    private function renderDocsIndex(): string
    {
        return '
            <div class="docs-index">
                <div class="docs-sections">
                    <div class="docs-section">
                        <h2>Getting Started</h2>
                        <p>New to Boson PHP? Start here to learn the basics.</p>
                        <ul>
                            <li><a href="/docs/latest/installation">Installation</a></li>
                            <li><a href="/docs/latest/first-app">Your First App</a></li>
                            <li><a href="/docs/latest/project-structure">Project Structure</a></li>
                        </ul>
                    </div>

                    <div class="docs-section">
                        <h2>Core Concepts</h2>
                        <p>Learn the fundamental concepts of desktop development with PHP.</p>
                        <ul>
                            <li><a href="/docs/latest/windows">Windows & Views</a></li>
                            <li><a href="/docs/latest/events">Event Handling</a></li>
                            <li><a href="/docs/latest/native-apis">Native APIs</a></li>
                        </ul>
                    </div>

                    <div class="docs-section">
                        <h2>Advanced Topics</h2>
                        <p>Deep dive into advanced features and optimization techniques.</p>
                        <ul>
                            <li><a href="/docs/latest/performance">Performance</a></li>
                            <li><a href="/docs/latest/packaging">Packaging & Distribution</a></li>
                            <li><a href="/docs/latest/debugging">Debugging</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        ';
    }

    private function renderDocsVersion(string $version): string
    {
        return $this->renderDocsIndex();
    }

    private function renderDocsSidebar(string $version = 'latest', string $currentSlug = ''): string
    {
        $sections = [
            'Getting Started' => [
                'installation'      => 'Installation',
                'first-app'         => 'Your First App',
                'project-structure' => 'Project Structure',
            ],
            'Core Concepts' => [
                'windows'     => 'Windows & Views',
                'events'      => 'Event Handling',
                'native-apis' => 'Native APIs',
            ],
            'Advanced Topics' => [
                'performance' => 'Performance',
                'packaging'   => 'Packaging & Distribution',
                'debugging'   => 'Debugging',
            ],
        ];

        $html = '<nav class="docs-sidebar">';

        foreach ($sections as $sectionTitle => $items) {
            $html .= '<div class="sidebar-section">';
            $html .= '<h3>' . $sectionTitle . '</h3>';
            $html .= '<ul>';

            foreach ($items as $slug => $title) {
                $isActive = $slug === $currentSlug ? ' class="active"' : '';
                $html .= '<li' . $isActive . '>';
                $html .= '<a href="/docs/' . $version . '/' . $slug . '">' . $title . '</a>';
                $html .= '</li>';
            }

            $html .= '</ul>';
            $html .= '</div>';
        }

        $html .= '</nav>';

        return $html;
    }

    private function getDocumentBySlug(string $slug): array
    {
        // Mock documentation content
        $docs = [
            'installation' => [
                'title'       => 'Installation',
                'description' => 'Learn how to install Boson PHP on your system.',
                'content'     => '
                    <h2 id="system-requirements">System Requirements</h2>
                    <p>Before installing Boson PHP, make sure your system meets these requirements:</p>
                    <ul>
                        <li>PHP 8.1 or higher</li>
                        <li>Composer</li>
                        <li>Node.js 16+ (for building assets)</li>
                    </ul>

                    <h2 id="installation-steps">Installation Steps</h2>
                    <p>Install Boson PHP using Composer:</p>
                    <pre><code>composer create-project boson/desktop-app my-app</code></pre>

                    <h2 id="verify-installation">Verify Installation</h2>
                    <p>Run your first application:</p>
                    <pre><code>cd my-app
php boson serve</code></pre>
                ',
                'toc' => [
                    ['title' => 'System Requirements', 'anchor' => 'system-requirements'],
                    ['title' => 'Installation Steps', 'anchor' => 'installation-steps'],
                    ['title' => 'Verify Installation', 'anchor' => 'verify-installation'],
                ],
            ],
            'first-app' => [
                'title'       => 'Your First App',
                'description' => 'Create your first desktop application with Boson PHP.',
                'content'     => '
                    <h2 id="creating-window">Creating a Simple Window</h2>
                    <p>Let\'s create a simple "Hello World" application with Boson PHP:</p>
                    <pre><code><?php
use Boson\Window;

$window = new Window([
    "title" => "Hello World",
    "width" => 800,
    "height" => 600
]);

$window->show();
?></code></pre>

                    <h2 id="adding-content">Adding Content</h2>
                    <p>Now let\'s add some HTML content to our window:</p>
                    <pre><code>$window->loadHTML(\'
                        <h1>Hello from Boson PHP!</h1>
                        <p>This is my first desktop app.</p>
                    \');</code></pre>

                    <h2 id="handling-events">Handling Events</h2>
                    <p>You can handle window events like close, resize, etc:</p>
                    <pre><code>$window->on(\'close\', function() {
    echo "Window is closing...";
});</code></pre>
                ',
                'toc' => [
                    ['title' => 'Creating a Simple Window', 'anchor' => 'creating-window'],
                    ['title' => 'Adding Content', 'anchor' => 'adding-content'],
                    ['title' => 'Handling Events', 'anchor' => 'handling-events'],
                ],
            ],
        ];

        return $docs[$slug] ?? [
            'title'       => 'Page Not Found',
            'description' => 'The requested documentation page was not found.',
            'content'     => '<p>The requested documentation page was not found.</p>',
            'toc'         => [],
        ];
    }
}
