<?php

declare(strict_types=1);

namespace Database\Seeders;

use Boson\Shared\Infrastructure\Database;

class ArticleSeeder
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function run(): void
    {
        // Disable foreign key constraints temporarily
        $this->database->getConnection()->exec('PRAGMA foreign_keys = OFF');

        // First ensure we have categories, users and authors
        $this->seedCategories();
        $this->seedUsers();
        $this->seedAuthors();

        $articles = $this->getArticleData();

        $sql = 'INSERT OR IGNORE INTO articles (title, slug, excerpt, content, featured_image, status, category_id, author_id, published_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->database->getConnection()->prepare($sql);

        foreach ($articles as $article) {
            $stmt->execute([
                $article['title'],
                $article['slug'],
                $article['excerpt'],
                $article['content'],
                $article['image'],
                'published',
                $this->getCategoryId($article['category']),
                $this->getAuthorId($article['author']),
                $article['published_at'],
                $article['created_at'],
                $article['updated_at']
            ]);
        }

        // Re-enable foreign key constraints
        $this->database->getConnection()->exec('PRAGMA foreign_keys = ON');

        echo "✅ Seeded " . count($articles) . " articles\n";
    }

    private function seedCategories(): void
    {
        $categories = [
            ['Tutorial', 'tutorial', 'Step-by-step tutorials'],
            ['Development', 'development', 'Development guides and tips'],
            ['Best Practices', 'best-practices', 'Best practices and patterns'],
            ['Performance', 'performance', 'Performance optimization'],
            ['Integration', 'integration', 'System integration guides'],
            ['Testing', 'testing', 'Testing and debugging'],
        ];

        $sql = 'INSERT OR IGNORE INTO categories (name, slug, description) VALUES (?, ?, ?)';
        $stmt = $this->database->getConnection()->prepare($sql);

        foreach ($categories as $category) {
            $stmt->execute($category);
        }
    }

    private function seedUsers(): void
    {
        $sql = 'INSERT OR IGNORE INTO users (email, password, name, role) VALUES (?, ?, ?, ?)';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute(['admin@bosonphp.com', password_hash('admin123', PASSWORD_DEFAULT), 'Admin User', 'admin']);
    }

    private function seedAuthors(): void
    {
        $authors = [
            ['Boson Team', 'team@bosonphp.com', 'The official Boson PHP development team.', null],
            ['Sarah Johnson', 'sarah@bosonphp.com', 'Senior Frontend Developer with expertise in desktop UI frameworks.', null],
            ['Mike Chen', 'mike@bosonphp.com', 'Cross-platform development specialist and system architect.', null],
            ['Alex Rodriguez', 'alex@bosonphp.com', 'Performance optimization expert and core contributor.', null],
            ['Emma Wilson', 'emma@bosonphp.com', 'System integration specialist and API developer.', null],
            ['David Kim', 'david@bosonphp.com', 'Testing and QA lead with focus on desktop applications.', null],
        ];

        $sql = 'INSERT OR IGNORE INTO authors (name, email, bio, avatar) VALUES (?, ?, ?, ?)';
        $stmt = $this->database->getConnection()->prepare($sql);

        foreach ($authors as $author) {
            $stmt->execute($author);
        }
    }

    private function getCategoryId(string $categoryName): int
    {
        $sql = 'SELECT id FROM categories WHERE name = ?';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$categoryName]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? (int)$result['id'] : 1;
    }

    private function getAuthorId(string $authorName): int
    {
        $sql = 'SELECT id FROM authors WHERE name = ?';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$authorName]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? (int)$result['id'] : 1;
    }

    private function getArticleData(): array
    {
        return [
            [
                'title' => 'Getting Started with Boson PHP',
                'slug' => 'getting-started-with-boson-php',
                'excerpt' => 'Learn how to build your first desktop application with Boson PHP. This comprehensive guide covers installation, setup, and creating your first window.',
                'content' => $this->getGettingStartedContent(),
                'author' => 'Boson Team',
                'category' => 'Tutorial',
                'image' => '/assets/shared/images/articles/getting-started.jpg',
                'published_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'title' => 'Building Native UI Components',
                'slug' => 'building-native-ui-components',
                'excerpt' => 'Discover how to create beautiful, native-looking UI components that feel at home on any operating system.',
                'content' => $this->getNativeUIContent(),
                'author' => 'Sarah Johnson',
                'category' => 'Development',
                'image' => '/assets/shared/images/articles/ui-components.jpg',
                'published_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'title' => 'Cross-Platform Development Best Practices',
                'slug' => 'cross-platform-development-best-practices',
                'excerpt' => 'Essential tips and techniques for building applications that work seamlessly across Windows, macOS, and Linux.',
                'content' => $this->getCrossPlatformContent(),
                'author' => 'Mike Chen',
                'category' => 'Best Practices',
                'image' => '/assets/shared/images/articles/cross-platform.jpg',
                'published_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'title' => 'Performance Optimization Techniques',
                'slug' => 'performance-optimization-techniques',
                'excerpt' => 'Learn advanced techniques to make your Boson PHP applications lightning fast and memory efficient.',
                'content' => $this->getPerformanceContent(),
                'author' => 'Alex Rodriguez',
                'category' => 'Performance',
                'image' => '/assets/shared/images/articles/performance.jpg',
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'Integrating with System APIs',
                'slug' => 'integrating-with-system-apis',
                'excerpt' => 'Explore how to access native system features like notifications, file system, and hardware integration.',
                'content' => $this->getSystemAPIContent(),
                'author' => 'Emma Wilson',
                'category' => 'Integration',
                'image' => '/assets/shared/images/articles/system-apis.jpg',
                'published_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'title' => 'Debugging and Testing Desktop Apps',
                'slug' => 'debugging-and-testing-desktop-apps',
                'excerpt' => 'Master the art of debugging and testing desktop applications with practical examples and proven strategies.',
                'content' => $this->getDebuggingContent(),
                'author' => 'David Kim',
                'category' => 'Testing',
                'image' => '/assets/shared/images/articles/debugging.jpg',
                'published_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
    }

    private function getGettingStartedContent(): string
    {
        return <<<'HTML'
<img src="/assets/shared/images/articles/getting-started-hero.jpg" alt="Getting Started" class="article-hero-image" />

<h2>Welcome to Boson PHP</h2>

<p>Boson PHP brings the familiar syntax and ecosystem of PHP to desktop application development. In this tutorial, we'll walk through creating your first desktop application.</p>

<h3>Installation</h3>

<p>First, make sure you have PHP 8.1 or higher installed on your system. Then install Boson PHP via Composer:</p>

<pre><code>composer create-project boson/app my-desktop-app
cd my-desktop-app</code></pre>

<h3>Your First Window</h3>

<p>Let's create a simple "Hello World" application:</p>

<pre><code>&lt;?php

use Boson\Window;
use Boson\Application;

$app = new Application();

$window = new Window([
    'title' => 'My First Boson App',
    'width' => 800,
    'height' => 600
]);

$window->loadHTML('&lt;h1&gt;Hello, Desktop World!&lt;/h1&gt;');
$window->show();

$app->run();</code></pre>

<h3>Next Steps</h3>

<p>Now that you have your first window running, you can explore:</p>

<ul>
<li>Adding interactive elements with JavaScript</li>
<li>Styling with CSS frameworks</li>
<li>Handling user input and events</li>
<li>Accessing system resources</li>
</ul>

<p>Check out our other tutorials to dive deeper into Boson PHP development!</p>
HTML;
    }

    private function getNativeUIContent(): string
    {
        return <<<'HTML'
<h2>Creating Native-Looking Components</h2>

<p>One of the key advantages of Boson PHP is the ability to create applications that feel native to each operating system while using familiar web technologies.</p>

<h3>Platform-Specific Styling</h3>

<p>Boson PHP automatically detects the operating system and applies appropriate styling:</p>

<pre><code>// Automatic platform detection
$window = new Window([
    'title' => 'Native App',
    'nativeStyle' => true,
    'theme' => 'auto' // Follows system theme
]);</code></pre>

<h3>Custom Components</h3>

<p>Build reusable components that adapt to each platform:</p>

<pre><code>class NativeButton extends Component 
{
    public function render(): string 
    {
        $platform = $this->getPlatform();
        $class = "btn btn-{$platform}";
        
        return "&lt;button class='{$class}'&gt;{$this->text}&lt;/button&gt;";
    }
}</code></pre>

<h3>Best Practices</h3>

<ul>
<li>Use system fonts for better integration</li>
<li>Follow platform-specific UI guidelines</li>
<li>Test on all target platforms</li>
<li>Respect system accessibility settings</li>
</ul>
HTML;
    }

    private function getCrossPlatformContent(): string
    {
        return <<<'HTML'
<h2>Cross-Platform Development</h2>

<p>Building applications that work seamlessly across Windows, macOS, and Linux requires careful planning and attention to platform differences.</p>

<h3>File System Handling</h3>

<p>Use Boson's built-in path utilities for cross-platform compatibility:</p>

<pre><code>use Boson\FileSystem\Path;

// Cross-platform path handling
$configPath = Path::join(Path::userHome(), '.myapp', 'config.json');
$dataDir = Path::appData('MyApp');</code></pre>

<h3>Platform Detection</h3>

<p>Adapt your application behavior based on the operating system:</p>

<pre><code>use Boson\Platform;

if (Platform::isWindows()) {
    // Windows-specific code
} elseif (Platform::isMacOS()) {
    // macOS-specific code
} elseif (Platform::isLinux()) {
    // Linux-specific code
}</code></pre>

<h3>Packaging and Distribution</h3>

<p>Boson PHP provides tools for packaging your application for each platform:</p>

<pre><code># Build for all platforms
php boson build --all

# Build for specific platform
php boson build --platform=windows
php boson build --platform=macos
php boson build --platform=linux</code></pre>
HTML;
    }

    private function getPerformanceContent(): string
    {
        return <<<'HTML'
<h2>Performance Optimization</h2>

<p>Desktop applications need to be responsive and efficient. Here are key techniques to optimize your Boson PHP applications.</p>

<h3>Memory Management</h3>

<p>Proper memory management is crucial for desktop applications:</p>

<pre><code>// Use weak references for event listeners
$window->on('close', WeakReference::create($handler));

// Clean up resources explicitly
$window->destroy();
unset($window);</code></pre>

<h3>Lazy Loading</h3>

<p>Load resources only when needed:</p>

<pre><code>class LazyComponent extends Component
{
    private $data = null;
    
    public function getData() 
    {
        if ($this->data === null) {
            $this->data = $this->loadExpensiveData();
        }
        return $this->data;
    }
}</code></pre>

<h3>Background Processing</h3>

<p>Keep the UI responsive with background tasks:</p>

<pre><code>use Boson\Threading\Worker;

$worker = new Worker(function() {
    // Heavy computation in background
    return processLargeDataset();
});

$worker->onComplete(function($result) {
    // Update UI with result
    $this->updateDisplay($result);
});</code></pre>

<h3>Profiling and Monitoring</h3>

<p>Use built-in profiling tools to identify bottlenecks:</p>

<pre><code>Boson\Profiler::start('expensive-operation');
// Your code here
Boson\Profiler::end('expensive-operation');

// View profiling results
Boson\Profiler::report();</code></pre>
HTML;
    }

    private function getSystemAPIContent(): string
    {
        return <<<'HTML'
<h2>System Integration</h2>

<p>Boson PHP provides extensive APIs for integrating with the operating system, giving your applications native capabilities.</p>

<h3>Notifications</h3>

<p>Send native system notifications:</p>

<pre><code>use Boson\System\Notification;

$notification = new Notification([
    'title' => 'Task Complete',
    'body' => 'Your file has been processed successfully.',
    'icon' => 'assets/icon.png'
]);

$notification->show();</code></pre>

<h3>File System Access</h3>

<p>Access files and directories with proper permissions:</p>

<pre><code>use Boson\FileSystem\FileDialog;

$dialog = new FileDialog([
    'type' => 'open',
    'filters' => [
        ['name' => 'Images', 'extensions' => ['jpg', 'png', 'gif']],
        ['name' => 'All Files', 'extensions' => ['*']]
    ]
]);

$files = $dialog->showModal();</code></pre>

<h3>System Tray</h3>

<p>Create system tray applications:</p>

<pre><code>use Boson\System\Tray;

$tray = new Tray([
    'icon' => 'assets/tray-icon.png',
    'tooltip' => 'My Application'
]);

$tray->setContextMenu([
    ['label' => 'Show Window', 'click' => [$this, 'showWindow']],
    ['type' => 'separator'],
    ['label' => 'Quit', 'click' => [$this, 'quit']]
]);</code></pre>

<h3>Hardware Integration</h3>

<p>Access hardware features when available:</p>

<pre><code>use Boson\Hardware\Camera;
use Boson\Hardware\Microphone;

// Check if camera is available
if (Camera::isAvailable()) {
    $camera = new Camera();
    $stream = $camera->getVideoStream();
}

// Access microphone
if (Microphone::hasPermission()) {
    $mic = new Microphone();
    $audioData = $mic->record(5000); // 5 seconds
}</code></pre>
HTML;
    }

    private function getDebuggingContent(): string
    {
        return <<<'HTML'
<h2>Debugging and Testing</h2>

<p>Effective debugging and testing strategies are essential for building reliable desktop applications with Boson PHP.</p>

<h3>Development Tools</h3>

<p>Boson PHP includes built-in development tools:</p>

<pre><code>// Enable debug mode
$app = new Application(['debug' => true]);

// Open developer console
$window->openDevTools();

// Log to console
$window->console()->log('Debug message');
$window->console()->error('Error occurred');</code></pre>

<h3>Unit Testing</h3>

<p>Test your application components:</p>

<pre><code>use PHPUnit\Framework\TestCase;
use Boson\Testing\WindowTestCase;

class MyComponentTest extends WindowTestCase
{
    public function testButtonClick()
    {
        $window = $this->createTestWindow();
        $window->loadHTML('&lt;button id="test"&gt;Click me&lt;/button&gt;');
        
        $button = $window->getElementById('test');
        $button->click();
        
        $this->assertTrue($button->hasClass('clicked'));
    }
}</code></pre>

<h3>Integration Testing</h3>

<p>Test complete user workflows:</p>

<pre><code>class UserWorkflowTest extends TestCase
{
    public function testFileProcessingWorkflow()
    {
        $app = new TestApplication();
        
        // Simulate file selection
        $app->selectFile('test-data.csv');
        
        // Process file
        $app->clickButton('process');
        
        // Verify results
        $this->assertFileExists('output/processed-data.json');
    }
}</code></pre>

<h3>Error Handling</h3>

<p>Implement robust error handling:</p>

<pre><code>use Boson\Exception\BosonException;

try {
    $result = $this->riskyOperation();
} catch (BosonException $e) {
    // Log error
    $this->logger->error($e->getMessage());
    
    // Show user-friendly message
    $this->showErrorDialog('Operation failed. Please try again.');
    
    // Report to crash reporting service
    $this->crashReporter->report($e);
}</code></pre>
HTML;
    }
}
