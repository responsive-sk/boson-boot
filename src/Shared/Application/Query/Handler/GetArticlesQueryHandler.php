<?php

declare(strict_types=1);

namespace Boson\Shared\Application\Query\Handler;

use Boson\Shared\Application\Query\Article\GetArticlesQuery;
use Boson\Shared\Presentation\Response\ArticlesResponse;
use Boson\Shared\Presentation\Response\ArticleResponse;
use Boson\Blog\Application\ArticleService;

/**
 * Get Articles Query Handler
 */
class GetArticlesQueryHandler
{
    public function __construct(private ArticleService $articleService) {}

    public function handle(GetArticlesQuery $query): ArticlesResponse
    {
        // Use legacy ArticleService for now
        $result = $this->articleService->getPaginatedArticles(
            $query->getPage(),
            $query->getPerPage()
        );

        // Convert legacy format to new response format
        $articleResponses = array_map(
            fn($article) => $this->convertToArticleResponse($article),
            $result['articles']
        );

        return ArticlesResponse::create(
            articles: $articleResponses,
            total: $result['total'],
            currentPage: $result['currentPage'],
            perPage: $query->getPerPage()
        );
    }

    private function convertToArticleResponse($article): ArticleResponse
    {
        // Convert legacy article object to ArticleResponse
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
