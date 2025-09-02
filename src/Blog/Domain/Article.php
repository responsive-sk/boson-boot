<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

use DateTimeImmutable;
use DomainException;

class Article
{
    private ?int $id = null;
    private string $title;
    private string $slug;
    private ?string $excerpt;
    private string $content;
    private ?string $featuredImage;
    private ArticleStatus $status;
    private ?int $categoryId;
    private int $authorId;
    private ?DateTimeImmutable $publishedAt = null;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    private function __construct(
        string $title,
        string $slug,
        string $content,
        int $authorId,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null,
        ArticleStatus $status = ArticleStatus::DRAFT
    ) {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->excerpt = $excerpt;
        $this->featuredImage = $featuredImage;
        $this->categoryId = $categoryId;
        $this->status = $status;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public static function create(
        string $title,
        string $slug,
        string $content,
        int $authorId,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): self {
        return new self(
            title: $title,
            slug: $slug,
            content: $content,
            authorId: $authorId,
            excerpt: $excerpt,
            featuredImage: $featuredImage,
            categoryId: $categoryId
        );
    }

    public function publish(): void
    {
        if ($this->status === ArticleStatus::PUBLISHED) {
            throw new DomainException('Article is already published');
        }

        $this->status = ArticleStatus::PUBLISHED;
        $this->publishedAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function unpublish(): void
    {
        if ($this->status !== ArticleStatus::PUBLISHED) {
            throw new DomainException('Article is not published');
        }

        $this->status = ArticleStatus::DRAFT;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function archive(): void
    {
        $this->status = ArticleStatus::ARCHIVED;
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

    public static function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug ?? '', '-');
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

    public function getStatus(): ArticleStatus
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

    // Status checks
    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === ArticleStatus::DRAFT;
    }

    public function isArchived(): bool
    {
        return $this->status === ArticleStatus::ARCHIVED;
    }

    // Serialization
    /**
     * @return array<string, mixed>
     */
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
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['title'], $data['slug'], $data['content'], $data['author_id'], $data['status'])) {
            throw new \InvalidArgumentException('Missing required fields for Article creation');
        }

        $article = new self(
            title: (string) $data['title'],
            slug: (string) $data['slug'],
            content: (string) $data['content'],
            authorId: (int) $data['author_id'],
            excerpt: isset($data['excerpt']) ? (string) $data['excerpt'] : null,
            featuredImage: isset($data['featured_image']) ? (string) $data['featured_image'] : null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            status: ArticleStatus::from((string) $data['status'])
        );

        $article->id = isset($data['id']) ? (int) $data['id'] : null;

        if (isset($data['published_at']) && $data['published_at']) {
            $article->publishedAt = new DateTimeImmutable((string) $data['published_at']);
        }

        if (isset($data['created_at'])) {
            $article->createdAt = new DateTimeImmutable((string) $data['created_at']);
        }

        if (isset($data['updated_at'])) {
            $article->updatedAt = new DateTimeImmutable((string) $data['updated_at']);
        }

        return $article;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
