<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;

/**
 * Article Status Value Object
 */
final class ArticleStatus implements ValueObject
{
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';
    public const ARCHIVED = 'archived';

    private const VALID_STATUSES = [
        self::DRAFT,
        self::PUBLISHED,
        self::ARCHIVED
    ];

    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $normalized = strtolower(trim($value));
        
        if (!in_array($normalized, self::VALID_STATUSES, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid article status: %s. Valid statuses: %s',
                    $value,
                    implode(', ', self::VALID_STATUSES)
                )
            );
        }

        return new self($normalized);
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

    public function isDraft(): bool
    {
        return $this->value === self::DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->value === self::PUBLISHED;
    }

    public function isArchived(): bool
    {
        return $this->value === self::ARCHIVED;
    }
}
