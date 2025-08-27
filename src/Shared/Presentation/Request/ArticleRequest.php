<?php

declare(strict_types=1);

namespace Boson\Shared\Presentation\Request;

/**
 * Article Request Object
 */
final class ArticleRequest
{
    public function __construct(
        private string $title,
        private string $content,
        private string $status = 'draft',
        private ?string $excerpt = null,
        private ?int $categoryId = null,
        private ?int $authorId = null,
        private array $tags = []
    ) {
        $this->validateTitle($title);
        $this->validateContent($content);
        $this->validateStatus($status);
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

    private function validateTitle(string $title): void
    {
        $trimmed = trim($title);
        
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('Title is required');
        }

        if (strlen($trimmed) < 3) {
            throw new \InvalidArgumentException('Title must be at least 3 characters long');
        }

        if (strlen($trimmed) > 255) {
            throw new \InvalidArgumentException('Title cannot exceed 255 characters');
        }
    }

    private function validateContent(string $content): void
    {
        $trimmed = trim($content);
        
        if (empty($trimmed)) {
            throw new \InvalidArgumentException('Content is required');
        }

        if (strlen($trimmed) < 10) {
            throw new \InvalidArgumentException('Content must be at least 10 characters long');
        }
    }

    private function validateStatus(string $status): void
    {
        $validStatuses = ['draft', 'published', 'archived'];
        
        if (!in_array($status, $validStatuses, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid status: %s. Valid statuses: %s', 
                    $status, 
                    implode(', ', $validStatuses)
                )
            );
        }
    }

    /**
     * Create from HTTP request data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            status: $data['status'] ?? 'draft',
            excerpt: $data['excerpt'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            authorId: isset($data['author_id']) ? (int) $data['author_id'] : null,
            tags: $data['tags'] ?? []
        );
    }

    /**
     * Create from global $_POST
     */
    public static function fromPost(): self
    {
        return self::fromArray($_POST);
    }

    /**
     * Convert to array for command creation
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'category_id' => $this->categoryId,
            'author_id' => $this->authorId,
            'tags' => $this->tags,
        ];
    }
}
