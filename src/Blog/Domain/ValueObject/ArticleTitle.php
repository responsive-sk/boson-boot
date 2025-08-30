<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;

/**
 * Article Title Value Object
 */
final class ArticleTitle implements ValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $trimmed = trim($value);
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('Article title cannot be empty');
        }

        if (mb_strlen($trimmed) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article title must be at least %d characters long', self::MIN_LENGTH)
            );
        }

        if (mb_strlen($trimmed) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article title cannot exceed %d characters', self::MAX_LENGTH)
            );
        }

        return new self($trimmed);
    }

    public function toString(): string
    {
        return $this->value;
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
