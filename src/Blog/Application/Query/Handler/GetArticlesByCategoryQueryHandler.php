<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Query\Handler;

use Boson\Blog\Application\Query\Article\GetArticlesByCategoryQuery;
use Boson\Blog\Application\ArticleService;
use Boson\Blog\Presentation\Response\ArticleResponse;

/**
 * Get Articles by Category Query Handler
 */
class GetArticlesByCategoryQueryHandler
{
    public function __construct(private ArticleService $articleService) {}

    public function handle(GetArticlesByCategoryQuery $query): array
    {
        $articles = $this->articleService->getArticlesByCategory(
            $query->getCategoryId(),
            $query->getLimit(),
            $query->getOffset(),
            $query->isPublishedOnly()
        );

        return array_map(
            fn($article) => new ArticleResponse(
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
            ),
            $articles
        );
    }
}
