<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Handler;

use Boson\Blog\Application\Query\Article\GetArticleBySlugQuery;
use Boson\Blog\Application\ArticleService;
use Boson\Blog\Presentation\Response\ArticleResponse;

/**
 * Get Article by Slug Query Handler
 */
class GetArticleBySlugQueryHandler
{
    public function __construct(private ArticleService $articleService) {}

    public function handle(GetArticleBySlugQuery $query): ?ArticleResponse
    {
        $article = $this->articleService->getArticleBySlug($query->getSlug());

        if ($article === null) {
            return null;
        }

        if ($query->isPublishedOnly() && !$article->isPublished()) {
            return null;
        }

        return new ArticleResponse(
            id: $article->getId(),
            title: $article->getTitle(),
            content: $article->getContent(),
            status: $article->getStatus()->value,
            excerpt: $article->getExcerpt(),
            slug: $article->getSlug(),
            featuredImage: $article->getFeaturedImage(),
            categoryId: $article->getCategoryId(),
            categoryName: null,
            authorId: $article->getAuthorId(),
            authorName: null,
            tags: [], // Article domain doesn't have tags yet
            createdAt: $article->getCreatedAt(),
            updatedAt: $article->getUpdatedAt(),
            publishedAt: $article->getPublishedAt()
        );
    }
}
