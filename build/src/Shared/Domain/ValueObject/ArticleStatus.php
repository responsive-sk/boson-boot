<?php

declare(strict_types=1);

namespace Boson\Shared\Domain\ValueObject;

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
        self::ARCHIVED,
    ];

    private function __construct(private string $value)
    {
        if (!in_array($value, self::VALID_STATUSES, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid article status: %s. Valid statuses: %s', 
                    $value, 
                    implode(', ', self::VALID_STATUSES)
                )
            );
        }
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function published(): self
    {
        return new self(self::PUBLISHED);
    }

    public static function archived(): self
    {
        return new self(self::ARCHIVED);
    }

    public static function fromString(string $value): self
    {
        return new self(strtolower(trim($value)));
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

    /**
     * Get human-readable label
     */
    public function getLabel(): string
    {
        return match($this->value) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived',
        };
    }

    /**
     * Get CSS class for styling
     */
    public function getCssClass(): string
    {
        return match($this->value) {
            self::DRAFT => 'status-draft',
            self::PUBLISHED => 'status-published',
            self::ARCHIVED => 'status-archived',
        };
    }
}
