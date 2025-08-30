<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Monitoring;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareInterface;

class CompressionMiddleware implements MiddlewareInterface
{
    private bool $enabled;
    private int $compressionLevel;
    private int $minLength;

    public function __construct(bool $enabled = true, int $compressionLevel = 6, int $minLength = 1024)
    {
        $this->enabled = $enabled;
        $this->compressionLevel = max(1, min(9, $compressionLevel));
        $this->minLength = max(0, $minLength);
    }

    public function handle(array $request, callable $next): array
    {
        // Process request through next middleware first
        $response = $next($request);

        // If response is available and should be compressed
        if (isset($response['response']) && is_string($response['response'])) {
            $response = $this->compressResponse($response);
        }

        return $response;
    }

    private function compressResponse(array $response): array
    {
        $content = $response['response'];
        $headers = $response['headers'] ?? [];

        // Check if we should compress
        if (!$this->enabled || !$this->shouldCompress($content, $headers)) {
            return $response;
        }

        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

        // Compress based on client support
        if (strpos($acceptEncoding, 'gzip') !== false) {
            return $this->compressGzip($response, $content, $headers);
        }

        if (strpos($acceptEncoding, 'deflate') !== false) {
            return $this->compressDeflate($response, $content, $headers);
        }

        return $response;
    }

    private function shouldCompress(string $content, array $headers): bool
    {
        // Don't compress if content is too small
        if (strlen($content) < $this->minLength) {
            return false;
        }

        // Don't compress if already compressed
        if (isset($headers['Content-Encoding'])) {
            return false;
        }

        // Check content type
        $contentType = $headers['Content-Type'] ?? 'text/html';

        $compressibleTypes = [
            'text/html', 'text/css', 'text/javascript', 'text/plain', 'text/xml',
            'application/javascript', 'application/json', 'application/xml',
            'application/rss+xml', 'application/atom+xml', 'image/svg+xml',
        ];

        foreach ($compressibleTypes as $type) {
            if (strpos($contentType, $type) === 0) {
                return true;
            }
        }

        return false;
    }

    private function compressGzip(array $response, string $content, array $headers): array
    {
        $compressed = gzencode($content, $this->compressionLevel);

        if ($compressed === false) {
            return $response;
        }

        // Update response with compressed content and headers
        $response['response'] = $compressed;
        $response['headers'] = array_merge($headers, [
            'Content-Encoding' => 'gzip',
            'Content-Length' => (string) strlen($compressed),
            'Vary' => isset($headers['Vary']) ? $headers['Vary'] . ', Accept-Encoding' : 'Accept-Encoding'
        ]);

        return $response;
    }

    private function compressDeflate(array $response, string $content, array $headers): array
    {
        $compressed = gzdeflate($content, $this->compressionLevel);

        if ($compressed === false) {
            return $response;
        }

        // Update response with compressed content and headers
        $response['response'] = $compressed;
        $response['headers'] = array_merge($headers, [
            'Content-Encoding' => 'deflate',
            'Content-Length' => (string) strlen($compressed),
            'Vary' => isset($headers['Vary']) ? $headers['Vary'] . ', Accept-Encoding' : 'Accept-Encoding'
        ]);

        return $response;
    }

    public static function enable(): void
    {
        // This static method is problematic - consider removing or refactoring
        // Output buffering should be handled at the application level, not in middleware
        error_log("CompressionMiddleware::enable() is deprecated. Use middleware instead.");
    }

    public function getCompressionRatio(string $original, string $compressed): float
    {
        $originalSize = strlen($original);
        $compressedSize = strlen($compressed);

        if ($originalSize === 0) {
            return 0.0;
        }

        return round((1 - ($compressedSize / $originalSize)) * 100, 2);
    }
}