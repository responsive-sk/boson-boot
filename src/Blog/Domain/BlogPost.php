<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

use DateTimeImmutable;

class BlogPost
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $slug,
        private ?string $excerpt,
        private string $content,
        private ?string $featuredImage,
        private BlogPostStatus $status,
        private ?int $categoryId,
        private int $authorId,
        private ?DateTimeImmutable $publishedAt,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt
    ) {}

    public static function create(
        string $title,
        string $slug,
        string $content,
        int $authorId,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): self {
        $now = new DateTimeImmutable();
        
        return new self(
            id: null,
            title: $title,
            slug: $slug,
            excerpt: $excerpt,
            content: $content,
            featuredImage: $featuredImage,
            status: BlogPostStatus::DRAFT,
            categoryId: $categoryId,
            authorId: $authorId,
            publishedAt: null,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public function publish(): void
    {
        if ($this->status === BlogPostStatus::PUBLISHED) {
            throw new \DomainException('Blog post is already published');
        }

        $this->status = BlogPostStatus::PUBLISHED;
        $this->publishedAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function unpublish(): void
    {
        if ($this->status !== BlogPostStatus::PUBLISHED) {
            throw new \DomainException('Blog post is not published');
        }

        $this->status = BlogPostStatus::DRAFT;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function archive(): void
    {
        $this->status = BlogPostStatus::ARCHIVED;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function updateContent(
        string $title,
        string $content,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): void {
        $this->title = $title;
        $this->content = $content;
        $this->excerpt = $excerpt;
        $this->featuredImage = $featuredImage;
        $this->categoryId = $categoryId;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function generateSlug(string $title): string
    {
        // Simple slug generation - can be enhanced
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }

    public function isPublished(): bool
    {
        return $this->status === BlogPostStatus::PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === BlogPostStatus::DRAFT;
    }

    public function isArchived(): bool
    {
        return $this->status === BlogPostStatus::ARCHIVED;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFeaturedImage(): ?string
    {
        return $this->featuredImage;
    }

    public function getStatus(): BlogPostStatus
    {
        return $this->status;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featuredImage,
            'status' => $this->status->value,
            'category_id' => $this->categoryId,
            'author_id' => $this->authorId,
            'published_at' => $this->publishedAt?->format('Y-m-d H:i:s'),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            slug: $data['slug'],
            excerpt: $data['excerpt'] ?? null,
            content: $data['content'],
            featuredImage: $data['featured_image'] ?? null,
            status: BlogPostStatus::from($data['status'] ?? 'draft'),
            categoryId: $data['category_id'] ?? null,
            authorId: $data['author_id'],
            publishedAt: $data['published_at'] ? new DateTimeImmutable($data['published_at']) : null,
            createdAt: new DateTimeImmutable($data['created_at']),
            updatedAt: new DateTimeImmutable($data['updated_at'])
        );
    }
}
