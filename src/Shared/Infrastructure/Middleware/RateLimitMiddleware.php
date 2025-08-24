<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Middleware;

use Boson\Shared\Infrastructure\Security\RateLimiter;

class RateLimitMiddleware implements MiddlewareInterface
{
    private RateLimiter $rateLimiter;
    private int $maxAttempts;
    private int $windowSeconds;

    public function __construct(
        ?RateLimiter $rateLimiter = null,
        int $maxAttempts = 100,
        int $windowSeconds = 300
    ) {
        $this->rateLimiter = $rateLimiter ?? new RateLimiter();
        $this->maxAttempts = $maxAttempts;
        $this->windowSeconds = $windowSeconds;
    }

    public function handle(array $request, callable $next): array
    {
        $identifier = $this->rateLimiter->getClientIdentifier();
        
        if (!$this->rateLimiter->isAllowed($identifier, $this->maxAttempts, $this->windowSeconds)) {
            $timeUntilReset = $this->rateLimiter->getTimeUntilReset($identifier, $this->windowSeconds);
            
            http_response_code(429);
            header('Retry-After: ' . $timeUntilReset);
            header('Content-Type: application/json');
            
            $request['response'] = json_encode([
                'error' => 'Too Many Requests',
                'message' => 'Rate limit exceeded. Try again in ' . $timeUntilReset . ' seconds.',
                'retry_after' => $timeUntilReset
            ]);
            
            $request['stop_execution'] = true;
            return $request;
        }
        
        $this->rateLimiter->recordAttempt($identifier);
        return $next($request);
    }
}
