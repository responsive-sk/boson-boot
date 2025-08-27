<?php

declare(strict_types=1);

namespace Boson\Shared\Domain\ValueObject;

/**
 * Article ID Value Object
 */
final class ArticleId implements ValueObject
{
    private function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Article ID must be positive integer');
        }
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public static function fromString(string $value): self
    {
        $intValue = filter_var($value, FILTER_VALIDATE_INT);
        
        if ($intValue === false) {
            throw new \InvalidArgumentException('Invalid article ID format');
        }

        return new self($intValue);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $other->value === $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
