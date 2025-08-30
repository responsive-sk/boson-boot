<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Command\Article;

use Boson\Blog\Domain\ValueObject\ArticleId;

/**
 * Delete Article Command
 */
final class DeleteArticleCommand
{
    public function __construct(private ArticleId $id) {}

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public static function fromInt(int $id): self
    {
        return new self(ArticleId::fromInt($id));
    }

    public static function fromString(string $id): self
    {
        return new self(ArticleId::fromString($id));
    }
}
