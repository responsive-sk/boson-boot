<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Middleware;

/**
 * JSON Response Middleware pre API endpoints
 */
class JsonMiddleware implements MiddlewareInterface
{
    private array $apiPaths;
    private bool $prettyPrint;
    private bool $forceJson;

    public function __construct(
        array $apiPaths = ['/api/'],
        bool $prettyPrint = false,
        bool $forceJson = false
    ) {
        $this->apiPaths = $apiPaths;
        $this->prettyPrint = $prettyPrint;
        $this->forceJson = $forceJson;
    }

    public function handle(array $request, callable $next): array
    {
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Check if this is an API request
        $isApiRequest = $this->forceJson || $this->isApiPath($path) || $this->isJsonRequest($request);

        if ($isApiRequest) {
            // Set JSON content type header
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
            }

            // Process request
            $response = $next($request);

            // Transform response to JSON if needed
            if (isset($response['response'])) {
                $response['response'] = $this->ensureJsonResponse($response['response']);
            }

            return $response;
        }

        // Not an API request, continue normally
        return $next($request);
    }

    /**
     * Check if path matches API patterns
     */
    private function isApiPath(string $path): bool
    {
        foreach ($this->apiPaths as $apiPath) {
            if (strpos($path, $apiPath) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if request expects JSON response
     */
    private function isJsonRequest(array $request): bool
    {
        // Check Accept header
        $accept = $request['headers']['Accept'] ?? $_SERVER['HTTP_ACCEPT'] ?? '';
        if (strpos($accept, 'application/json') !== false) {
            return true;
        }

        // Check Content-Type header
        $contentType = $request['headers']['Content-Type'] ?? $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            return true;
        }

        // Check for HTMX requests that expect JSON
        $htmxRequest = $request['headers']['Hx-Request'] ?? $_SERVER['HTTP_HX_REQUEST'] ?? '';
        $htmxAccept = $request['headers']['Hx-Accept'] ?? $_SERVER['HTTP_HX_ACCEPT'] ?? '';
        
        return !empty($htmxRequest) && strpos($htmxAccept, 'application/json') !== false;
    }

    /**
     * Ensure response is valid JSON
     */
    private function ensureJsonResponse(string $response): string
    {
        // If response is already valid JSON, return as is
        if ($this->isValidJson($response)) {
            return $this->formatJson($response);
        }

        // If response looks like an error message, wrap it
        if ($this->isErrorResponse($response)) {
            return $this->formatJson(json_encode([
                'error' => true,
                'message' => $response
            ]));
        }

        // If response is HTML, try to extract meaningful content
        if ($this->isHtmlResponse($response)) {
            $content = $this->extractHtmlContent($response);
            return $this->formatJson(json_encode([
                'success' => true,
                'data' => $content
            ]));
        }

        // Default: wrap plain text response
        return $this->formatJson(json_encode([
            'success' => true,
            'data' => $response
        ]));
    }

    /**
     * Check if string is valid JSON
     */
    private function isValidJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Check if response is an error
     */
    private function isErrorResponse(string $response): bool
    {
        $errorIndicators = [
            'error', 'Error', 'ERROR',
            'exception', 'Exception',
            'failed', 'Failed',
            'not found', 'Not Found',
            'forbidden', 'Forbidden',
            'unauthorized', 'Unauthorized'
        ];

        foreach ($errorIndicators as $indicator) {
            if (strpos($response, $indicator) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if response is HTML
     */
    private function isHtmlResponse(string $response): bool
    {
        return strpos(trim($response), '<') === 0;
    }

    /**
     * Extract meaningful content from HTML
     */
    private function extractHtmlContent(string $html): string
    {
        // Remove HTML tags and get text content
        $text = strip_tags($html);
        
        // Clean up whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // If text is too long, truncate it
        if (strlen($text) > 500) {
            $text = substr($text, 0, 497) . '...';
        }

        return $text;
    }

    /**
     * Format JSON with pretty print if enabled
     */
    private function formatJson(string $json): string
    {
        if (!$this->prettyPrint) {
            return $json;
        }

        $data = json_decode($json, true);
        if ($data === null) {
            return $json;
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Add API path pattern
     */
    public function addApiPath(string $path): self
    {
        if (!in_array($path, $this->apiPaths, true)) {
            $this->apiPaths[] = $path;
        }
        return $this;
    }

    /**
     * Enable/disable pretty printing
     */
    public function setPrettyPrint(bool $enabled): self
    {
        $this->prettyPrint = $enabled;
        return $this;
    }

    /**
     * Force JSON for all requests
     */
    public function setForceJson(bool $force): self
    {
        $this->forceJson = $force;
        return $this;
    }

    /**
     * Create middleware for API-only applications
     */
    public static function forApiOnly(): self
    {
        return new self(
            apiPaths: ['/'],  // All paths
            prettyPrint: false,
            forceJson: true
        );
    }

    /**
     * Create middleware for development with pretty printing
     */
    public static function forDevelopment(): self
    {
        return new self(
            apiPaths: ['/api/', '/ajax/'],
            prettyPrint: true,
            forceJson: false
        );
    }
}
