<?php

declare(strict_types=1);

namespace Boson\Blog\Presentation\Request;

/**
 * Article Request Object
 */
final class ArticleRequest
{
    public function __construct(
        private array $data
    ) {}

    public function getTitle(): string
    {
        return $this->data['title'] ?? '';
    }

    public function getContent(): string
    {
        return $this->data['content'] ?? '';
    }

    public function getExcerpt(): ?string
    {
        return $this->data['excerpt'] ?? null;
    }

    public function getSlug(): ?string
    {
        return $this->data['slug'] ?? null;
    }

    public function getFeaturedImage(): ?string
    {
        return $this->data['featured_image'] ?? null;
    }

    public function getStatus(): string
    {
        return $this->data['status'] ?? 'draft';
    }

    public function getCategoryId(): ?int
    {
        return isset($this->data['category_id']) ? (int) $this->data['category_id'] : null;
    }

    public function getAuthorId(): ?int
    {
        return isset($this->data['author_id']) ? (int) $this->data['author_id'] : null;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
