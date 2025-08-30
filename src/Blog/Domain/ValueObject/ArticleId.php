<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;

/**
 * Article ID Value Object
 */
final class ArticleId implements ValueObject
{
    private function __construct(private int $value) {}

    public static function fromInt(int $value): self
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Article ID must be positive integer');
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

    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
