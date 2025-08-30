<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Command\Article;

use Boson\Blog\Domain\ValueObject\ArticleTitle;
use Boson\Blog\Domain\ValueObject\ArticleContent;
use Boson\Blog\Domain\ValueObject\ArticleStatus;

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
        private ?string $slug = null,
        private ?string $featuredImage = null,
        private ?int $categoryId = null,
        private ?int $authorId = null
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

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: ArticleTitle::fromString($data['title']),
            content: ArticleContent::fromString($data['content']),
            status: ArticleStatus::fromString($data['status'] ?? 'draft'),
            excerpt: $data['excerpt'] ?? null,
            slug: $data['slug'] ?? null,
            featuredImage: $data['featured_image'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            authorId: isset($data['author_id']) ? (int) $data['author_id'] : null
        );
    }
}
