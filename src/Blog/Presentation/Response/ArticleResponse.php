<?php

declare(strict_types=1);

namespace Boson\Blog\Presentation\Response;

use Boson\Blog\Domain\Article;

/**
 * Article Response Object
 */
final class ArticleResponse
{
    public function __construct(
        private int $id,
        private string $title,
        private string $content,
        private string $status,
        private ?string $excerpt,
        private string $slug,
        private ?string $featuredImage,
        private ?int $categoryId,
        private ?string $categoryName,
        private ?int $authorId,
        private ?string $authorName,
        private array $tags,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
        private ?\DateTimeImmutable $publishedAt
    ) {}

    /**
     * Create from Article domain object
     */
    public static function fromArticle(Article $article): self
    {
        return new self(
            id: $article->getId(),
            title: $article->getTitle(),
            content: $article->getContent(),
            status: $article->getStatus(),
            excerpt: $article->getExcerpt(),
            slug: $article->getSlug(),
            categoryId: $article->getCategoryId(),
            categoryName: null, // Would be populated by service
            authorId: $article->getAuthorId(),
            authorName: null, // Would be populated by service
            tags: $article->getTags(),
            createdAt: $article->getCreatedAt(),
            updatedAt: $article->getUpdatedAt(),
            publishedAt: $article->getPublishedAt()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function getSlug(): string
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

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }
}
