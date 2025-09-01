<?php

declare(strict_types=1);

namespace Boson\Blog\Domain\ValueObject;

use Boson\Shared\Domain\ValueObject\ValueObject;
use Boson\Shared\Infrastructure\Security\InputValidator;

/**
 * Article Content Value Object
 *
 * Represents validated article content with length constraints.
 * Ensures content is between 10-10000 characters and trimmed.
 *
 * @example
 * // Valid usage
 * $content = ArticleContent::fromString('This is the article content.');
 * echo $content->value(); // "This is the article content."
 * echo $content; // "This is the article content." (via __toString)
 *
 * // Comparison
 * $content1 = ArticleContent::fromString('Content');
 * $content2 = ArticleContent::fromString('Content');
 * $content1->equals($content2); // true
 *
 * @throws \InvalidArgumentException When content is invalid
 */
final class ArticleContent implements ValueObject
{
    private const MIN_LENGTH = 10;
    private const MAX_LENGTH = 10000;

    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $trimmed = trim($value);

        $validator = new InputValidator();
        $rules = [
            'content' => ['required', 'string', ['min', self::MIN_LENGTH], ['max', self::MAX_LENGTH]]
        ];

        if (!$validator->validate(['content' => $trimmed], $rules)) {
            throw new \InvalidArgumentException($validator->getFirstError() ?? 'Invalid content');
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
