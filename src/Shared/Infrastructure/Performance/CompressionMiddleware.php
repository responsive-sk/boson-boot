<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Performance;

class CompressionMiddleware
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

    public function handle(string $content, array $headers = []): array
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
            'image/svg+xml'
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
        $headers['Content-Length'] = (string) strlen($compressed);
        $headers['Vary'] = isset($headers['Vary']) 
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
        $headers['Content-Length'] = (string) strlen($compressed);
        $headers['Vary'] = isset($headers['Vary']) 
            ? $headers['Vary'] . ', Accept-Encoding' 
            : 'Accept-Encoding';

        return ['content' => $compressed, 'headers' => $headers];
    }

    public static function enable(): void
    {
        if (!headers_sent()) {
            $middleware = new self();
            
            ob_start(function($content) use ($middleware) {
                $headers = [];
                
                // Capture current headers
                foreach (headers_list() as $header) {
                    $parts = explode(':', $header, 2);
                    if (count($parts) === 2) {
                        $headers[trim($parts[0])] = trim($parts[1]);
                    }
                }

                $result = $middleware->handle($content, $headers);
                
                // Set new headers
                foreach ($result['headers'] as $name => $value) {
                    header("$name: $value");
                }

                return $result['content'];
            });
        }
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
