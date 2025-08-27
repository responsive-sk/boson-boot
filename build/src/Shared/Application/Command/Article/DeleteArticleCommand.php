<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Command\Article;

use Boson\Shared\Domain\ValueObject\ArticleId;

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

    /**
     * Create from integer ID
     */
    public static function fromInt(int $id): self
    {
        return new self(ArticleId::fromInt($id));
    }

    /**
     * Create from string ID
     */
    public static function fromString(string $id): self
    {
        return new self(ArticleId::fromString($id));
    }
}
