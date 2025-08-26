<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Security;

use function array_slice;
use function count;
use function in_array;

class CsrfProtection
{
    private const TOKEN_LENGTH = 32;

    private const SESSION_KEY = '_csrf_tokens';

    private const MAX_TOKENS = 10;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generateToken(string $action = 'default'): string
    {
        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));

        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        // Store token with timestamp
        $_SESSION[self::SESSION_KEY][$action] = [
            'token'     => $token,
            'timestamp' => time(),
        ];

        // Clean old tokens
        $this->cleanOldTokens();

        return $token;
    }

    public function validateToken(string $token, string $action = 'default'): bool
    {
        if (!isset($_SESSION[self::SESSION_KEY][$action])) {
            return false;
        }

        $storedData = $_SESSION[self::SESSION_KEY][$action];

        // Check if token matches
        if (!hash_equals($storedData['token'], $token)) {
            return false;
        }

        // Check if token is not too old (1 hour)
        if (time() - $storedData['timestamp'] > 3600) {
            unset($_SESSION[self::SESSION_KEY][$action]);

            return false;
        }

        // Token is valid, remove it (one-time use)
        unset($_SESSION[self::SESSION_KEY][$action]);

        return true;
    }

    public function getTokenFromRequest(): ?string
    {
        // Check POST data first
        if (isset($_POST['_token'])) {
            return $_POST['_token'];
        }

        // Check headers (for AJAX requests)
        $headers = getallheaders();
        if (isset($headers['X-CSRF-Token'])) {
            return $headers['X-CSRF-Token'];
        }

        // Check GET parameters (not recommended but sometimes needed)
        if (isset($_GET['_token'])) {
            return $_GET['_token'];
        }

        return null;
    }

    public function validateRequest(string $action = 'default'): bool
    {
        $token = $this->getTokenFromRequest();

        if ($token === null) {
            return false;
        }

        return $this->validateToken($token, $action);
    }

    public function getHiddenInput(string $action = 'default'): string
    {
        $token = $this->generateToken($action);

        return '<input type="hidden" name="_token" value="' . htmlspecialchars($token, ENT_QUOTES) . '">';
    }

    public function getMetaTag(string $action = 'default'): string
    {
        $token = $this->generateToken($action);

        return '<meta name="csrf-token" content="' . htmlspecialchars($token, ENT_QUOTES) . '">';
    }

    public static function isSecureRequest(): bool
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }

    public static function requireSecureConnection(): void
    {
        if (!self::isSecureRequest() && !self::isLocalhost()) {
            header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
            exit;
        }
    }

    private function cleanOldTokens(): void
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            return;
        }

        $tokens      = $_SESSION[self::SESSION_KEY];
        $currentTime = time();

        // Remove expired tokens (older than 1 hour)
        foreach ($tokens as $action => $data) {
            if ($currentTime - $data['timestamp'] > 3600) {
                unset($_SESSION[self::SESSION_KEY][$action]);
            }
        }

        // If we have too many tokens, remove the oldest ones
        if (count($_SESSION[self::SESSION_KEY]) > self::MAX_TOKENS) {
            uasort($_SESSION[self::SESSION_KEY], static function ($a, $b) {
                return $a['timestamp'] <=> $b['timestamp'];
            });

            $_SESSION[self::SESSION_KEY] = array_slice(
                $_SESSION[self::SESSION_KEY],
                -self::MAX_TOKENS,
                null,
                true,
            );
        }
    }

    private static function isLocalhost(): bool
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';

        return in_array($host, ['localhost', '127.0.0.1', '::1'], true)
               || strpos($host, 'localhost:') === 0;
    }
}
