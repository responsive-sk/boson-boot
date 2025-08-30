<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Security;

class RateLimiter
{
    private const SESSION_KEY = '_rate_limits';

    private const DEFAULT_WINDOW = 3600; // 1 hour

    private const DEFAULT_MAX_ATTEMPTS = 60; // 60 requests per hour

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function isAllowed(
        string $identifier,
        int $maxAttempts = self::DEFAULT_MAX_ATTEMPTS,
        int $windowSeconds = self::DEFAULT_WINDOW,
    ): bool {
        $this->cleanExpiredEntries();

        if (!isset($_SESSION[self::SESSION_KEY][$identifier])) {
            $_SESSION[self::SESSION_KEY][$identifier] = [
                'attempts'     => 0,
                'window_start' => time(),
            ];
        }

        $data        = $_SESSION[self::SESSION_KEY][$identifier];
        $currentTime = time();

        // Reset window if expired
        if ($currentTime - $data['window_start'] >= $windowSeconds) {
            $_SESSION[self::SESSION_KEY][$identifier] = [
                'attempts'     => 0,
                'window_start' => $currentTime,
            ];
            $data = $_SESSION[self::SESSION_KEY][$identifier];
        }

        return $data['attempts'] < $maxAttempts;
    }

    public function recordAttempt(string $identifier): void
    {
        if (!isset($_SESSION[self::SESSION_KEY][$identifier])) {
            $_SESSION[self::SESSION_KEY][$identifier] = [
                'attempts'     => 0,
                'window_start' => time(),
            ];
        }

        ++$_SESSION[self::SESSION_KEY][$identifier]['attempts'];
    }

    public function getRemainingAttempts(
        string $identifier,
        int $maxAttempts = self::DEFAULT_MAX_ATTEMPTS,
    ): int {
        if (!isset($_SESSION[self::SESSION_KEY][$identifier])) {
            return $maxAttempts;
        }

        $attempts = $_SESSION[self::SESSION_KEY][$identifier]['attempts'];

        return max(0, $maxAttempts - $attempts);
    }

    public function getTimeUntilReset(
        string $identifier,
        int $windowSeconds = self::DEFAULT_WINDOW,
    ): int {
        if (!isset($_SESSION[self::SESSION_KEY][$identifier])) {
            return 0;
        }

        $windowStart = $_SESSION[self::SESSION_KEY][$identifier]['window_start'];
        $windowEnd   = $windowStart + $windowSeconds;

        return max(0, $windowEnd - time());
    }

    public function reset(string $identifier): void
    {
        unset($_SESSION[self::SESSION_KEY][$identifier]);
    }

    public function getClientIdentifier(): string
    {
        // Use IP address and User-Agent for identification
        $ip        = $this->getClientIp();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        return hash('sha256', $ip . '|' . $userAgent);
    }

    public static function middleware(
        int $maxAttempts = self::DEFAULT_MAX_ATTEMPTS,
        int $windowSeconds = self::DEFAULT_WINDOW,
    ): callable {
        return static function () use ($maxAttempts, $windowSeconds) {
            $rateLimiter = new self();
            $identifier  = $rateLimiter->getClientIdentifier();

            if (!$rateLimiter->isAllowed($identifier, $maxAttempts, $windowSeconds)) {
                $timeUntilReset = $rateLimiter->getTimeUntilReset($identifier, $windowSeconds);

                http_response_code(429);
                header('Retry-After: ' . $timeUntilReset);
                header('Content-Type: application/json');

                echo json_encode([
                    'error'       => 'Too Many Requests',
                    'message'     => 'Rate limit exceeded. Try again in ' . $timeUntilReset . ' seconds.',
                    'retry_after' => $timeUntilReset,
                ]);

                exit;
            }

            $rateLimiter->recordAttempt($identifier);
        };
    }

    private function getClientIp(): string
    {
        // Check for various headers that might contain the real IP
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_FORWARDED_FOR',      // Load balancers/proxies
            'HTTP_X_FORWARDED',          // Proxies
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxies
            'HTTP_FORWARDED',            // Proxies
            'REMOTE_ADDR',               // Standard
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip  = trim($ips[0]);

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    private function cleanExpiredEntries(): void
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            return;
        }

        $currentTime = time();

        foreach ($_SESSION[self::SESSION_KEY] as $identifier => $data) {
            if ($currentTime - $data['window_start'] >= self::DEFAULT_WINDOW) {
                unset($_SESSION[self::SESSION_KEY][$identifier]);
            }
        }
    }
}
