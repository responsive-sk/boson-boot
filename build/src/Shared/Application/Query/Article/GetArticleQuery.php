<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Query\Article;

use Boson\Shared\Domain\ValueObject\ArticleId;

/**
 * Get Single Article Query
 */
final class GetArticleQuery
{
    public function __construct(
        private ArticleId $id,
        private bool $publishedOnly = true
    ) {}

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function isPublishedOnly(): bool
    {
        return $this->publishedOnly;
    }

    /**
     * Create from integer ID
     */
    public static function fromInt(int $id, bool $publishedOnly = true): self
    {
        return new self(ArticleId::fromInt($id), $publishedOnly);
    }

    /**
     * Create from string ID
     */
    public static function fromString(string $id, bool $publishedOnly = true): self
    {
        return new self(ArticleId::fromString($id), $publishedOnly);
    }
}
