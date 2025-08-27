<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Command\Article;

use Boson\Shared\Domain\ValueObject\ArticleTitle;
use Boson\Shared\Domain\ValueObject\ArticleContent;
use Boson\Shared\Domain\ValueObject\ArticleStatus;

/**
 * Create Article Command
 */
final class CreateArticleCommand
{
    public function __construct(
        private ArticleTitle $title,
        private ArticleContent $content,
        private ArticleStatus $status,
        private ?string $excerpt = null,
        private ?int $categoryId = null,
        private ?int $authorId = null,
        private array $tags = []
    ) {}

    public function getTitle(): ArticleTitle
    {
        return $this->title;
    }

    public function getContent(): ArticleContent
    {
        return $this->content;
    }

    public function getStatus(): ArticleStatus
    {
        return $this->status;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt ?? $this->content->toExcerpt();
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Create from array data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: ArticleTitle::fromString($data['title']),
            content: ArticleContent::fromString($data['content']),
            status: ArticleStatus::fromString($data['status'] ?? 'draft'),
            excerpt: $data['excerpt'] ?? null,
            categoryId: $data['category_id'] ?? null,
            authorId: $data['author_id'] ?? null,
            tags: $data['tags'] ?? []
        );
    }
}
