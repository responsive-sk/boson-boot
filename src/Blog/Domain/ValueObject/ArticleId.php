<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;
use Boson\Shared\Infrastructure\Security\InputValidator;

/**
 * Article ID Value Object
 *
 * Represents a validated article identifier with integer constraints.
 * Ensures IDs are positive integers (minimum value: 1).
 *
 * @example
 * // Valid usage
 * $id = ArticleId::fromInt(123);
 * echo $id->value(); // 123
 * echo $id->toString(); // "123"
 * echo $id; // "123" (via __toString)
 *
 * // From string
 * $id = ArticleId::fromString('456');
 * echo $id->value(); // 456
 *
 * // Comparison
 * $id1 = ArticleId::fromInt(100);
 * $id2 = ArticleId::fromInt(100);
 * $id1->equals($id2); // true
 *
 * @throws \InvalidArgumentException When ID is invalid
 */
final class ArticleId implements ValueObject
{
    private function __construct(private int $value) {}

    public static function fromInt(int $value): self
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('Field id must be at least 1');
        }

        $validator = new InputValidator();
        $rules = [
            'id' => ['required', 'integer']
        ];

        if (!$validator->validate(['id' => $value], $rules)) {
            throw new \InvalidArgumentException($validator->getFirstError() ?? 'Invalid ID');
        }

        return new self($value);
    }

    public static function fromString(string $value): self
    {
        $intValue = filter_var($value, FILTER_VALIDATE_INT);
        if ($intValue === false) {
            throw new \InvalidArgumentException('Invalid article ID format');
        }

        return self::fromInt($intValue);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function equals(?ValueObject $other): bool
    {
        if ($other === null) {
            return false;
        }
        return $other instanceof self && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
