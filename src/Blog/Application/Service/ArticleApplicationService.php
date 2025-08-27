<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Service;

use Boson\Shared\Application\Service\QueryBusInterface;
use Boson\Shared\Application\Service\CommandBusInterface;
use Boson\Shared\Application\Query\Article\GetArticleQuery;
use Boson\Shared\Application\Query\Article\GetArticleBySlugQuery;
use Boson\Shared\Application\Query\Article\GetArticlesQuery;
use Boson\Shared\Application\Query\Article\GetArticlesByCategoryQuery;
use Boson\Shared\Application\Command\Article\CreateArticleCommand;
use Boson\Shared\Application\Command\Article\UpdateArticleCommand;
use Boson\Shared\Application\Command\Article\DeleteArticleCommand;
use Boson\Shared\Presentation\Response\ArticleResponse;
use Boson\Shared\Presentation\Response\ArticlesResponse;

/**
 * Article Application Service
 * Orchestrates article-related operations using CQRS pattern
 */
class ArticleApplicationService
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {}

    /**
     * Get single article by ID
     */
    public function getArticle(int $id, bool $publishedOnly = true): ?ArticleResponse
    {
        $query = GetArticleQuery::fromInt($id, $publishedOnly);
        return $this->queryBus->handle($query);
    }

    /**
     * Get single article by slug
     */
    public function getArticleBySlug(string $slug, bool $publishedOnly = true): ?ArticleResponse
    {
        $query = new GetArticleBySlugQuery($slug, $publishedOnly);
        return $this->queryBus->handle($query);
    }

    /**
     * Get paginated articles
     */
    public function getArticles(
        int $page = 1,
        int $perPage = 10,
        ?int $categoryId = null,
        array $tags = [],
        bool $publishedOnly = true,
        string $sortBy = 'created_at',
        string $sortDirection = 'DESC'
    ): ArticlesResponse {
        $query = new GetArticlesQuery(
            page: $page,
            perPage: $perPage,
            categoryId: $categoryId,
            tags: $tags,
            publishedOnly: $publishedOnly,
            sortBy: $sortBy,
            sortDirection: $sortDirection
        );

        return $this->queryBus->handle($query);
    }

    /**
     * Get articles by category
     */
    public function getArticlesByCategory(
        int $categoryId,
        int $limit = 10,
        int $offset = 0,
        bool $publishedOnly = true
    ): array {
        $query = new GetArticlesByCategoryQuery(
            categoryId: $categoryId,
            limit: $limit,
            offset: $offset,
            publishedOnly: $publishedOnly
        );

        return $this->queryBus->handle($query);
    }

    /**
     * Create new article
     */
    public function createArticle(array $data): ArticleResponse
    {
        $command = CreateArticleCommand::fromArray($data);
        $articleId = $this->commandBus->handle($command);
        
        // Return the created article
        return $this->getArticle($articleId, false);
    }

    /**
     * Update existing article
     */
    public function updateArticle(int $id, array $data): ArticleResponse
    {
        $command = UpdateArticleCommand::fromArray($id, $data);
        $this->commandBus->handle($command);
        
        // Return the updated article
        return $this->getArticle($id, false);
    }

    /**
     * Delete article
     */
    public function deleteArticle(int $id): bool
    {
        $command = DeleteArticleCommand::fromInt($id);
        return $this->commandBus->handle($command);
    }

    /**
     * Get paginated articles with legacy format for backward compatibility
     */
    public function getPaginatedArticles(int $page, int $perPage): array
    {
        $articlesResponse = $this->getArticles($page, $perPage);
        
        return [
            'articles' => $articlesResponse->getArticles(),
            'total' => $articlesResponse->getTotal(),
            'currentPage' => $articlesResponse->getCurrentPage(),
            'totalPages' => $articlesResponse->getTotalPages(),
            'hasMore' => $articlesResponse->hasMore(),
            'pagination' => [
                'current_page' => $articlesResponse->getCurrentPage(),
                'total_pages' => $articlesResponse->getTotalPages(),
                'has_more' => $articlesResponse->hasMore(),
                'has_previous' => $articlesResponse->hasPrevious(),
            ]
        ];
    }
}
