<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Boson\Shared\Infrastructure\PathManager;
use Boson\Shared\Infrastructure\Path\PathCacheInterface;
use Boson\Shared\Infrastructure\Path\PathResolverInterface;
use Boson\Shared\Infrastructure\Path\PathEventInterface;
use PHPUnit\Framework\TestCase;

class PathManagerTest extends TestCase
{
    protected function setUp(): void
    {
        // Clear any existing cache and listeners
        PathManager::clearCache();
        PathManager::removeListeners('path.resolved');
        PathManager::removeListeners('directory.before_create');
        PathManager::removeListeners('directory.created');
    }

    public function testBasicPathResolution(): void
    {
        $rootPath = PathManager::root();
        $this->assertIsString($rootPath);
        $this->assertDirectoryExists($rootPath);

        $srcPath = PathManager::src();
        $this->assertStringContainsString('src', $srcPath);
        $this->assertDirectoryExists($srcPath);
    }

    public function testPathCaching(): void
    {
        // Enable caching
        PathManager::setCacheEnabled(true);

        $cache = PathManager::getCache();
        $this->assertInstanceOf(PathCacheInterface::class, $cache);

        // Get a path and check if it's cached
        $path1 = PathManager::src('test');
        $this->assertTrue($cache->has('path_src_test'));

        // Get the same path again - should come from cache
        $path2 = PathManager::src('test');
        $this->assertEquals($path1, $path2);

        // Check cache stats
        $stats = PathManager::getCacheStats();
        $this->assertGreaterThan(0, $stats['hits']);
    }

    public function testCacheDisabled(): void
    {
        PathManager::setCacheEnabled(false);
        
        $path1 = PathManager::src('test');
        $cache = PathManager::getCache();
        
        $this->assertFalse($cache->has('path_src_test'));
        
        // Re-enable for other tests
        PathManager::setCacheEnabled(true);
    }

    public function testPathSecurityValidation(): void
    {
        // Test valid paths
        $this->assertTrue(PathManager::isSecure('valid/path'));
        $this->assertTrue(PathManager::isSecure('normal-directory/file.txt'));

        // Test invalid paths
        $this->assertFalse(PathManager::isSecure('../traversal'));
        $this->assertFalse(PathManager::isSecure('/absolute/path'));
        $this->assertFalse(PathManager::isSecure("path\0withnull"));
        $this->assertFalse(PathManager::isSecure("path\x01withcontrol"));
    }

    public function testPathSanitization(): void
    {
        $sanitized = PathManager::sanitize('../dangerous/../path');
        $this->assertEquals('dangerous/path', $sanitized);

        $sanitized = PathManager::sanitize('//multiple//slashes//');
        $this->assertEquals('multiple/slashes', $sanitized);

        $sanitized = PathManager::sanitize("path\0with\x01control");
        $this->assertEquals('pathwithcontrol', $sanitized);
    }

    public function testEventSystem(): void
    {
        $events = [];
        
        // Add event listener
        PathManager::addListener('path.resolved', function(PathEventInterface $event) use (&$events) {
            $events[] = [
                'name' => $event->getName(),
                'path' => $event->getPath(),
                'params' => $event->getParams()
            ];
        });

        // Trigger path resolution
        $path = PathManager::src('test-event');
        
        $this->assertCount(1, $events);
        $this->assertEquals('path.resolved', $events[0]['name']);
        $this->assertEquals($path, $events[0]['path']);
        $this->assertArrayHasKey('type', $events[0]['params']);
    }

    public function testDirectoryEvents(): void
    {
        $events = [];
        
        PathManager::addListener('directory.before_create', function(PathEventInterface $event) use (&$events) {
            $events[] = ['before_create' => $event->getPath()];
        });
        
        PathManager::addListener('directory.created', function(PathEventInterface $event) use (&$events) {
            $events[] = ['created' => $event->getPath()];
        });

        $testDir = PathManager::ensureDirectory('test-dir-events');
        
        $this->assertCount(2, $events);
        $this->assertArrayHasKey('before_create', $events[0]);
        $this->assertArrayHasKey('created', $events[1]);
        
        // Clean up
        rmdir($testDir);
    }

    public function testEventPropagation(): void
    {
        $callCount = 0;
        
        PathManager::addListener('path.resolved', function(PathEventInterface $event) use (&$callCount) {
            $callCount++;
            $event->stopPropagation();
        }, 10); // High priority
        
        PathManager::addListener('path.resolved', function() {
            $this->fail('This listener should not be called due to propagation stop');
        }, 5); // Lower priority

        PathManager::src('test-propagation');
        
        $this->assertEquals(1, $callCount);
    }

    public function testCustomCacheImplementation(): void
    {
        $mockCache = $this->createMock(PathCacheInterface::class);
        $mockCache->method('has')->willReturn(false);
        $mockCache->method('get')->willReturn('/custom/cached/path');
        $mockCache->method('set')->willReturnCallback(function($key, $path) {
            $this->assertStringContainsString('src', $key);
            $this->assertIsString($path);
        });

        PathManager::setCache($mockCache);
        
        $path = PathManager::src('test-custom-cache');
        $this->assertEquals('/custom/cached/path', $path);
        
        // Restore default cache
        PathManager::setCache(null);
    }

    public function testCustomResolver(): void
    {
        $mockResolver = $this->createMock(PathResolverInterface::class);
        $mockResolver->method('supports')->willReturn(true);
        $mockResolver->method('getPriority')->willReturn(100);
        $mockResolver->method('resolve')->willReturn('/custom/resolved/path');

        PathManager::addResolver($mockResolver);
        
        $path = PathManager::src('test-custom-resolver');
        $this->assertEquals('/custom/resolved/path', $path);
        
        // Clean up
        PathManager::removeListeners('path.resolved');
    }

    public function testRelativePath(): void
    {
        $absolutePath = PathManager::src('test-relative');
        $relativePath = PathManager::relative($absolutePath);
        
        $this->assertStringStartsWith('src/test-relative', $relativePath);
        $this->assertFalse(str_contains($relativePath, '..'));
    }

    public function testValidatePath(): void
    {
        $this->assertTrue(PathManager::validatePath('valid/path'));
        $this->assertTrue(PathManager::validatePath('path-with-dashes_and.underscores'));
        
        $this->assertFalse(PathManager::validatePath('../traversal'));
        $this->assertFalse(PathManager::validatePath('/absolute/path'));
        $this->assertFalse(PathManager::validatePath(''));
        
        // Test absolute path validation
        $absolutePath = PathManager::src('test');
        $this->assertTrue(PathManager::validatePath($absolutePath, true));
    }

    public function testCacheClear(): void
    {
        // Add some items to cache
        PathManager::src('test-cache-clear');
        PathManager::storage('test-cache-clear');
        
        $statsBefore = PathManager::getCacheStats();
        $this->assertGreaterThan(0, $statsBefore['size']);
        
        PathManager::clearCache();
        
        $statsAfter = PathManager::getCacheStats();
        $this->assertEquals(0, $statsAfter['size']);
    }
}
