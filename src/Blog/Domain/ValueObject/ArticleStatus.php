<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;
use Boson\Shared\Infrastructure\Security\InputValidator;

/**
 * Article Status Value Object
 *
 * Represents validated article publication status with predefined values.
 * Supports draft, published, and archived states with case-insensitive input.
 *
 * @example
 * // Valid usage
 * $status = ArticleStatus::fromString('draft');
 * echo $status->value(); // "draft"
 * echo $status; // "draft" (via __toString)
 *
 * // Status checks
 * $status->isDraft(); // true
 * $status->isPublished(); // false
 * $status->isArchived(); // false
 *
 * // Case insensitive
 * $status = ArticleStatus::fromString('PUBLISHED');
 * echo $status->value(); // "published"
 *
 * // Comparison
 * $status1 = ArticleStatus::fromString('draft');
 * $status2 = ArticleStatus::fromString('draft');
 * $status1->equals($status2); // true
 *
 * // Constants
 * ArticleStatus::DRAFT; // "draft"
 * ArticleStatus::PUBLISHED; // "published"
 * ArticleStatus::ARCHIVED; // "archived"
 *
 * @throws \InvalidArgumentException When status is invalid
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

        $validator = new InputValidator();
        $rules = [
            'status' => ['required', 'string', ['in', ...self::VALID_STATUSES]]
        ];

        if (!$validator->validate(['status' => $normalized], $rules)) {
            throw new \InvalidArgumentException($validator->getFirstError() ?? 'Invalid status');
        }

        return new self($normalized);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
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
