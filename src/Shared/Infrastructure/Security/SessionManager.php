<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Security;

/**
 * Bezpečná správa session
 */
class SessionManager
{
    private static bool $started = false;

    /**
     * Spustenie session s bezpečnostnými nastaveniami
     */
    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        // Skip session in CLI mode
        if (php_sapi_name() === 'cli') {
            self::$started = true;
            return;
        }

        // Bezpečnostné nastavenia session
        $sessionConfig = [
            'cookie_httponly' => true,
            'cookie_secure' => self::isHttps(),
            'cookie_samesite' => 'Strict',
            'use_strict_mode' => true,
            'use_cookies' => true,
            'use_only_cookies' => true,
            'cookie_lifetime' => 0, // Session cookie
            'gc_maxlifetime' => 3600, // 1 hour
            'gc_probability' => 1,
            'gc_divisor' => 100,
        ];

        // Nastavenie session parametrov (len ak headers ešte neboli odoslané)
        if (!headers_sent()) {
            foreach ($sessionConfig as $key => $value) {
                ini_set("session.{$key}", (string) $value);
            }

            // Nastavenie session name
            session_name('BOSSON_SESSION');
        }

        // Spustenie session
        session_start();
        self::$started = true;

        // Regenerácia ID pre bezpečnosť
        if (!isset($_SESSION['_token'])) {
            self::regenerate();
            $_SESSION['_token'] = self::generateToken();
            $_SESSION['_created'] = time();
        }

        // Kontrola expirácie
        self::checkExpiration();
    }

    /**
     * Regenerácia session ID
     */
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Zničenie session
     */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            
            // Zmazanie session cookie
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            
            session_destroy();
            self::$started = false;
        }
    }

    /**
     * Získanie session hodnoty
     */
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Nastavenie session hodnoty
     */
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Odstránenie session hodnoty
     */
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Kontrola či existuje session hodnota
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Flash message - zobrazí sa len raz
     */
    public static function flash(string $key, $value = null)
    {
        self::start();
        
        if ($value === null) {
            // Získanie flash message
            $message = $_SESSION["_flash_{$key}"] ?? null;
            unset($_SESSION["_flash_{$key}"]);
            return $message;
        } else {
            // Nastavenie flash message
            $_SESSION["_flash_{$key}"] = $value;
        }
    }

    /**
     * Získanie CSRF tokenu
     */
    public static function getCsrfToken(): string
    {
        self::start();
        
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = self::generateToken();
        }
        
        return $_SESSION['_csrf_token'];
    }

    /**
     * Kontrola HTTPS
     */
    private static function isHttps(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }

    /**
     * Generovanie bezpečného tokenu
     */
    private static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Kontrola expirácie session
     */
    private static function checkExpiration(): void
    {
        $maxLifetime = (int) ini_get('session.gc_maxlifetime');
        $created = $_SESSION['_created'] ?? time();
        
        if (time() - $created > $maxLifetime) {
            self::destroy();
            self::start(); // Nová session
        }
    }

    /**
     * Získanie session ID
     */
    public static function getId(): string
    {
        return session_id();
    }

    /**
     * Kontrola či je session aktívna
     */
    public static function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }
}
