<?php

declare(strict_types=1);

namespace Boson\Blog\Application\Service;

use Boson\Shared\Application\Service\QueryBusInterface;
use Boson\Shared\Application\Service\CommandBusInterface;
use Boson\Blog\Application\Query\Article\GetArticleQuery;
use Boson\Blog\Application\Query\Article\GetArticleBySlugQuery;
use Boson\Blog\Application\Query\Article\GetArticlesQuery;
use Boson\Blog\Application\Query\Article\GetArticlesByCategoryQuery;
use Boson\Blog\Application\Command\Article\CreateArticleCommand;
use Boson\Blog\Application\Command\Article\UpdateArticleCommand;
use Boson\Blog\Application\Command\Article\DeleteArticleCommand;
use Boson\Blog\Presentation\Response\ArticleResponse;
use Boson\Blog\Presentation\Response\ArticlesResponse;

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
        $result = $this->queryBus->handle($query);
        return $result instanceof ArticleResponse ? $result : null;
    }

    /**
     * Get single article by slug
     */
    public function getArticleBySlug(string $slug, bool $publishedOnly = true): ?ArticleResponse
    {
        $query = new GetArticleBySlugQuery($slug, $publishedOnly);
        $result = $this->queryBus->handle($query);
        return $result instanceof ArticleResponse ? $result : null;
    }

    /**
     * Get paginated articles
     */
    public function getArticles(
        int $page = 1,
        int $perPage = 10
    ): ArticlesResponse {
        $query = new GetArticlesQuery(
            $page,
            $perPage
        );

        $result = $this->queryBus->handle($query);
        return $result instanceof ArticlesResponse ? $result : new ArticlesResponse([], 0, 1, 1);
    }

    /**
     * Get articles by category
     * @return array<ArticleResponse>
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

        $result = $this->queryBus->handle($query);
        return is_array($result) ? $result : [];
    }

    /**
     * Create new article
     * @param array<string, mixed> $data
     */
    public function createArticle(array $data): ArticleResponse
    {
        $command = CreateArticleCommand::fromArray($data);
        $articleId = $this->commandBus->handle($command);

        // Return the created article
        $article = $this->getArticle($articleId, false);
        return $article ?? throw new \RuntimeException('Failed to create article');
    }

    /**
     * Update existing article
     * @param array<string, mixed> $data
     */
    public function updateArticle(int $id, array $data): ArticleResponse
    {
        $command = UpdateArticleCommand::fromArray($id, $data);
        $this->commandBus->handle($command);

        // Return the updated article
        $article = $this->getArticle($id, false);
        return $article ?? throw new \RuntimeException('Failed to update article');
    }

    /**
     * Delete article
     */
    public function deleteArticle(int $id): bool
    {
        $command = DeleteArticleCommand::fromInt($id);
        $result = $this->commandBus->handle($command);
        return (bool) $result;
    }

    /**
     * Get paginated articles with legacy format for backward compatibility
     * @return array<string, mixed>
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
