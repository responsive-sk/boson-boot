<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Traits;

use Boson\Shared\Infrastructure\Security\InputValidator;
use Boson\Shared\Infrastructure\Security\RateLimiter;

/**
 * Trait pre validáciu a security
 */
trait HasValidation
{
    /**
     * Validate input data
     */
    protected function validate(array $data, array $rules): bool
    {
        $validator = new InputValidator();
        return $validator->validate($data, $rules);
    }

    /**
     * Validate s error response
     */
    protected function validateOrFail(array $data, array $rules, string $errorTemplate = 'partials::validation-error'): ?string
    {
        if (!$this->validate($data, $rules)) {
            return $this->fragment($errorTemplate, [
                'errors' => $this->getValidationErrors($data, $rules)
            ]);
        }
        return null;
    }

    /**
     * Rate limiting check
     */
    protected function checkRateLimit(string $key, int $limit = 60, int $window = 3600): bool
    {
        $rateLimiter = new RateLimiter();
        $identifier = $rateLimiter->getClientIdentifier() . ':' . $key;
        
        return $rateLimiter->isAllowed($identifier, $limit, $window);
    }

    /**
     * Rate limit or fail
     */
    protected function rateLimitOrFail(string $key, int $limit = 60, int $window = 3600, string $message = 'Too many requests'): ?string
    {
        if (!$this->checkRateLimit($key, $limit, $window)) {
            http_response_code(429);
            return $this->fragment('partials::rate-limit-error', [
                'message' => $message
            ]);
        }
        return null;
    }

    /**
     * Get validation errors (simplified)
     */
    private function getValidationErrors(array $data, array $rules): array
    {
        // Simplified error extraction
        $errors = [];
        foreach ($rules as $field => $fieldRules) {
            if (!isset($data[$field]) && in_array('required', $fieldRules)) {
                $errors[$field] = "Field {$field} is required";
            }
        }
        return $errors;
    }
}
