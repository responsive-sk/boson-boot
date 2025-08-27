<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Monitoring;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareInterface;
use function count;
use function strlen;

class CompressionMiddleware implements MiddlewareInterface
{
    private bool $enabled;

    private int $compressionLevel;

    private int $minLength;

    public function __construct(bool $enabled = true, int $compressionLevel = 6, int $minLength = 1024)
    {
        $this->enabled          = $enabled;
        $this->compressionLevel = max(1, min(9, $compressionLevel));
        $this->minLength        = max(0, $minLength);
    }

    public function handle(array $request, callable $next): array
    {
        // Process request through next middleware first
        $request = $next($request);

        // If response is available, compress it
        if (isset($request['response']) && is_string($request['response'])) {
            $headers = [];

            // Capture current headers
            foreach (headers_list() as $header) {
                $parts = explode(':', $header, 2);
                if (count($parts) === 2) {
                    $headers[trim($parts[0])] = trim($parts[1]);
                }
            }

            $result = $this->compressContent($request['response'], $headers);

            // Set new headers
            foreach ($result['headers'] as $name => $value) {
                header("{$name}: {$value}");
            }

            $request['response'] = $result['content'];
        }

        return $request;
    }

    public function compressContent(string $content, array $headers = []): array
    {
        if (!$this->enabled || !$this->shouldCompress($content, $headers)) {
            return ['content' => $content, 'headers' => $headers];
        }

        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

        if (strpos($acceptEncoding, 'gzip') !== false) {
            return $this->compressGzip($content, $headers);
        }

        if (strpos($acceptEncoding, 'deflate') !== false) {
            return $this->compressDeflate($content, $headers);
        }

        return ['content' => $content, 'headers' => $headers];
    }

    public static function enable(): void
    {
        if (!headers_sent()) {
            $middleware = new self();

            ob_start(static function ($content) use ($middleware) {
                $headers = [];

                // Capture current headers
                foreach (headers_list() as $header) {
                    $parts = explode(':', $header, 2);
                    if (count($parts) === 2) {
                        $headers[trim($parts[0])] = trim($parts[1]);
                    }
                }

                $result = $middleware->compressContent($content, $headers);

                // Set new headers
                foreach ($result['headers'] as $name => $value) {
                    header("{$name}: {$value}");
                }

                return $result['content'];
            });
        }
    }

    public function getCompressionRatio(string $original, string $compressed): float
    {
        $originalSize   = strlen($original);
        $compressedSize = strlen($compressed);

        if ($originalSize === 0) {
            return 0.0;
        }

        return round((1 - ($compressedSize / $originalSize)) * 100, 2);
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
            'text/html',
            'text/css',
            'text/javascript',
            'text/plain',
            'text/xml',
            'application/javascript',
            'application/json',
            'application/xml',
            'application/rss+xml',
            'application/atom+xml',
            'image/svg+xml',
        ];

        foreach ($compressibleTypes as $type) {
            if (strpos($contentType, $type) === 0) {
                return true;
            }
        }

        return false;
    }

    private function compressGzip(string $content, array $headers): array
    {
        $compressed = gzencode($content, $this->compressionLevel);

        if ($compressed === false) {
            return ['content' => $content, 'headers' => $headers];
        }

        $headers['Content-Encoding'] = 'gzip';
        $headers['Content-Length']   = (string) strlen($compressed);
        $headers['Vary']             = isset($headers['Vary'])
            ? $headers['Vary'] . ', Accept-Encoding'
            : 'Accept-Encoding';

        return ['content' => $compressed, 'headers' => $headers];
    }

    private function compressDeflate(string $content, array $headers): array
    {
        $compressed = gzdeflate($content, $this->compressionLevel);

        if ($compressed === false) {
            return ['content' => $content, 'headers' => $headers];
        }

        $headers['Content-Encoding'] = 'deflate';
        $headers['Content-Length']   = (string) strlen($compressed);
        $headers['Vary']             = isset($headers['Vary'])
            ? $headers['Vary'] . ', Accept-Encoding'
            : 'Accept-Encoding';

        return ['content' => $compressed, 'headers' => $headers];
    }
}
