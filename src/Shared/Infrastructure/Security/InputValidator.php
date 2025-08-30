<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Security;

use function array_slice;
use function in_array;
use function is_array;
use function is_bool;
use function is_string;
use function strlen;

class InputValidator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $this->validateField($field, $value, $fieldRules);
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        return !empty($this->errors) ? reset($this->errors)[0] : null;
    }

    public static function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public static function sanitizeEmail(string $email): string
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeUrl(string $url): string
    {
        return filter_var(trim($url), FILTER_SANITIZE_URL);
    }

    public static function sanitizeInt(string $input): int
    {
        return (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizeFloat(string $input): float
    {
        return (float) filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public static function stripTags(string $input, string $allowedTags = ''): string
    {
        return strip_tags($input, $allowedTags);
    }

    public static function escapeHtml(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function validateField(string $field, $value, array $rules): void
    {
        foreach ($rules as $rule) {
            if (is_string($rule)) {
                $this->applyRule($field, $value, $rule);
            } elseif (is_array($rule)) {
                $ruleName   = $rule[0];
                $ruleParams = array_slice($rule, 1);
                $this->applyRule($field, $value, $ruleName, $ruleParams);
            }
        }
    }

    private function applyRule(string $field, $value, string $rule, array $params = []): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, "Field {$field} is required");
                }
                break;

            case 'string':
                if ($value !== null && !is_string($value)) {
                    $this->addError($field, "Field {$field} must be a string");
                }
                break;

            case 'integer':
                if ($value !== null && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, "Field {$field} must be an integer");
                }
                break;

            case 'email':
                if ($value !== null && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Field {$field} must be a valid email address");
                }
                break;

            case 'url':
                if ($value !== null && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "Field {$field} must be a valid URL");
                }
                break;

            case 'min':
                $min = $params[0] ?? 0;
                if ($value !== null && strlen((string) $value) < $min) {
                    $this->addError($field, "Field {$field} must be at least {$min} characters");
                }
                break;

            case 'max':
                $max = $params[0] ?? 255;
                if ($value !== null && strlen((string) $value) > $max) {
                    $this->addError($field, "Field {$field} must not exceed {$max} characters");
                }
                break;

            case 'slug':
                if ($value !== null && !preg_match('/^[a-z0-9-]+$/', $value)) {
                    $this->addError($field, "Field {$field} must be a valid slug (lowercase letters, numbers, and hyphens only)");
                }
                break;

            case 'alpha':
                if ($value !== null && !preg_match('/^[a-zA-Z]+$/', $value)) {
                    $this->addError($field, "Field {$field} must contain only letters");
                }
                break;

            case 'alphanumeric':
                if ($value !== null && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                    $this->addError($field, "Field {$field} must contain only letters and numbers");
                }
                break;

            case 'in':
                if ($value !== null && !in_array($value, $params, true)) {
                    $allowed = implode(', ', $params);
                    $this->addError($field, "Field {$field} must be one of: {$allowed}");
                }
                break;

            case 'numeric':
                if ($value !== null && !is_numeric($value)) {
                    $this->addError($field, "Field {$field} must be numeric");
                }
                break;

            case 'boolean':
                if ($value !== null && !is_bool($value) && !in_array($value, ['0', '1', 'true', 'false'], true)) {
                    $this->addError($field, "Field {$field} must be a boolean value");
                }
                break;

            case 'date':
                if ($value !== null && !strtotime($value)) {
                    $this->addError($field, "Field {$field} must be a valid date");
                }
                break;

            case 'regex':
                $pattern = $params[0] ?? '';
                if ($value !== null && !preg_match($pattern, $value)) {
                    $this->addError($field, "Field {$field} format is invalid");
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
}
