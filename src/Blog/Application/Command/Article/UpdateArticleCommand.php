<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Command\Article;

use Boson\Blog\Domain\ValueObject\ArticleId;
use Boson\Blog\Domain\ValueObject\ArticleTitle;
use Boson\Blog\Domain\ValueObject\ArticleContent;
use Boson\Blog\Domain\ValueObject\ArticleStatus;

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
        private ?string $slug = null,
        private ?string $featuredImage = null,
        private ?int $categoryId = null
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
        return $this->excerpt;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getFeaturedImage(): ?string
    {
        return $this->featuredImage;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: ArticleId::fromInt($id),
            title: ArticleTitle::fromString($data['title']),
            content: ArticleContent::fromString($data['content']),
            status: ArticleStatus::fromString($data['status'] ?? 'draft'),
            excerpt: $data['excerpt'] ?? null,
            slug: $data['slug'] ?? null,
            featuredImage: $data['featured_image'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null
        );
    }
}
