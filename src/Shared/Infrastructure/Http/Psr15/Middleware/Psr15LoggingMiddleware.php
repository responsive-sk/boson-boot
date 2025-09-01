<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * PSR-15 compatible logging middleware
 */
class Psr15LoggingMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Log the incoming request
        $this->logger->info('PSR-15 Request received', [
            'method' => $request->getMethod(),
            'uri' => (string) $request->getUri(),
            'headers' => $request->getHeaders(),
            'query_params' => $request->getQueryParams(),
        ]);

        $startTime = microtime(true);

        try {
            // Process the request
            $response = $handler->handle($request);

            $duration = microtime(true) - $startTime;

            // Log the response
            $this->logger->info('PSR-15 Response sent', [
                'status_code' => $response->getStatusCode(),
                'duration_ms' => round($duration * 1000, 2),
                'response_size' => strlen((string) $response->getBody()),
            ]);

            return $response;
        } catch (\Throwable $e) {
            $duration = microtime(true) - $startTime;

            $this->logger->error('PSR-15 Request failed', [
                'method' => $request->getMethod(),
                'uri' => (string) $request->getUri(),
                'duration_ms' => round($duration * 1000, 2),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
