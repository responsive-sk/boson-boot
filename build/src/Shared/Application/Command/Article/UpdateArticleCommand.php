<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Command\Article;

use Boson\Shared\Domain\ValueObject\ArticleId;
use Boson\Shared\Domain\ValueObject\ArticleTitle;
use Boson\Shared\Domain\ValueObject\ArticleContent;
use Boson\Shared\Domain\ValueObject\ArticleStatus;

/**
 * Update Article Command
 */
final class UpdateArticleCommand
{
    public function __construct(
        private ArticleId $id,
        private ArticleTitle $title,
        private ArticleContent $content,
        private ArticleStatus $status,
        private ?string $excerpt = null,
        private ?int $categoryId = null,
        private array $tags = []
    ) {}

    public function getId(): ArticleId
    {
        return $this->id;
    }

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

    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Create from array data
     */
    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: ArticleId::fromInt($id),
            title: ArticleTitle::fromString($data['title']),
            content: ArticleContent::fromString($data['content']),
            status: ArticleStatus::fromString($data['status'] ?? 'draft'),
            excerpt: $data['excerpt'] ?? null,
            categoryId: $data['category_id'] ?? null,
            tags: $data['tags'] ?? []
        );
    }
}
