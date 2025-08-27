<?php

declare(strict_types=1);

namespace Boson\Shared\Domain\ValueObject;

/**
 * Article Content Value Object
 */
final class ArticleContent implements ValueObject
{
    private const MIN_LENGTH = 10;
    private const MAX_LENGTH = 100000;

    private function __construct(private string $value)
    {
        $trimmed = trim($value);
        
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('Article content cannot be empty');
        }

        if (strlen($trimmed) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article content must be at least %d characters long', self::MIN_LENGTH)
            );
        }

        if (strlen($trimmed) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Article content cannot exceed %d characters', self::MAX_LENGTH)
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
     * Generate excerpt from content
     */
    public function toExcerpt(int $length = 150): string
    {
        $plainText = strip_tags($this->value);
        
        if (strlen($plainText) <= $length) {
            return $plainText;
        }

        $excerpt = substr($plainText, 0, $length);
        $lastSpace = strrpos($excerpt, ' ');
        
        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }

    /**
     * Get word count
     */
    public function getWordCount(): int
    {
        $plainText = strip_tags($this->value);
        return str_word_count($plainText);
    }

    /**
     * Get reading time estimate (words per minute)
     */
    public function getReadingTime(int $wordsPerMinute = 200): int
    {
        return max(1, (int) ceil($this->getWordCount() / $wordsPerMinute));
    }
}
