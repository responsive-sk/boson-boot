<?php

declare(strict_types=1);

namespace Boson\Shared\Domain\ValueObject;

/**
 * Article Title Value Object
 */
final class ArticleTitle implements ValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    private function __construct(private string $value)
    {
        $trimmed = trim($value);
        
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('Article title cannot be empty');
        }

        if (strlen($trimmed) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article title must be at least %d characters long', self::MIN_LENGTH)
            );
        }

        if (strlen($trimmed) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article title cannot exceed %d characters', self::MAX_LENGTH)
            );
        }

        $this->value = $trimmed;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self && $other->value === $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Generate URL-friendly slug from title
     */
    public function toSlug(): string
    {
        $slug = strtolower($this->value);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
