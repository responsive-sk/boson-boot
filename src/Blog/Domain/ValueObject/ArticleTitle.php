<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;
use Boson\Shared\Infrastructure\Security\InputValidator;

/**
 * Article Title Value Object
 *
 * Represents a validated article title with business rules enforcement.
 * Ensures titles are between 3-255 characters and properly trimmed.
 *
 * @example
 * // Valid usage
 * $title = ArticleTitle::fromString('My Article Title');
 * echo $title->value(); // "My Article Title"
 * echo $title; // "My Article Title" (via __toString)
 *
 * // Comparison
 * $title1 = ArticleTitle::fromString('Title');
 * $title2 = ArticleTitle::fromString('Title');
 * $title1->equals($title2); // true
 *
 * @throws \InvalidArgumentException When title is invalid
 */
final class ArticleTitle implements ValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    private function __construct(private string $value) {}

    /**
     * Create an ArticleTitle from a string
     *
     * Validates the input string and creates a new ArticleTitle instance.
     * The string is trimmed and must be between 3-255 characters.
     *
     * @param string $value The title string to validate and create from
     * @return self New ArticleTitle instance
     * @throws \InvalidArgumentException When validation fails
     */
    public static function fromString(string $value): self
    {
        $trimmed = trim($value);

        $validator = new InputValidator();
        $rules = [
            'title' => ['required', 'string', ['min', self::MIN_LENGTH], ['max', self::MAX_LENGTH]]
        ];

        if (!$validator->validate(['title' => $trimmed], $rules)) {
            throw new \InvalidArgumentException($validator->getFirstError() ?? 'Invalid title');
        }

        return new self($trimmed);
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
}
