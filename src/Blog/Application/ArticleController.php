<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Application\Controller\AbstractController;
use Boson\Blog\Application\Service\ArticleApplicationService;
use Boson\Shared\Presentation\Request\PaginationRequest;

class ArticleController extends AbstractController
{
    private ArticleApplicationService $articleApplicationService;

    public function setArticleApplicationService(ArticleApplicationService $articleApplicationService): void
    {
        $this->articleApplicationService = $articleApplicationService;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function index(array $params = []): string
    {
        $paginationRequest = PaginationRequest::fromGlobals();

        $articlesResponse = $this->articleApplicationService->getArticles(
            page: $paginationRequest->getPage(),
            perPage: 6
        );

        $filters = [
            ['label' => 'All Posts', 'url' => '/articles', 'active' => true, 'count' => $articlesResponse->getTotal()],
            ['label' => 'Architecture', 'url' => '/articles?category=architecture', 'count' => 3],
            ['label' => 'DDD', 'url' => '/articles?category=ddd', 'count' => 2],
            ['label' => 'Patterns', 'url' => '/articles?category=patterns', 'count' => 2],
            ['label' => 'PHP', 'url' => '/articles?category=php', 'count' => 4],
            ['label' => 'Testing', 'url' => '/articles?category=testing', 'count' => 1]
        ];

        return $this->render('pages::articles', [
            'title' => 'Articles - Boson PHP',
            'description' => 'Read the latest articles about Boson PHP development',
            'pageTitle' => 'Blog',
            'pageSubtitle' => 'All Blog Posts',
            'breadcrumbs' => $this->breadcrumbs(['Blog']),
            'filters' => $filters,
            'background' => 'default',
            'articles' => $articlesResponse->getArticles(),
            'currentPage' => $articlesResponse->getCurrentPage(),
            'totalPages' => $articlesResponse->getTotalPages(),
            'hasMore' => $articlesResponse->hasMore(),
            'total' => $articlesResponse->getTotal(),
        ]);
    }

    public function show(array $params = []): string
    {
        $slug = $params['slug'] ?? '';

        if (empty($slug)) {
            return $this->notFound('Article Not Found');
        }

        $articleResponse = $this->articleApplicationService->getArticleBySlug($slug);

        if ($articleResponse === null) {
            return $this->notFound('Article Not Found');
        }

        // Get related articles (same category, excluding current)
        $relatedArticles = [];
        if ($articleResponse->getCategoryId()) {
            $relatedArticles = $this->articleApplicationService->getArticlesByCategory(
                categoryId: $articleResponse->getCategoryId(),
                limit: 4
            );
            // Filter out current article and limit to 3
            $relatedArticles = array_filter(
                $relatedArticles,
                fn($a) => $a->getId() !== $articleResponse->getId()
            );
            $relatedArticles = array_slice($relatedArticles, 0, 3);
        }

        return $this->render('pages::article', [
            'title' => $articleResponse->getTitle() . ' - Boson PHP',
            'description' => $articleResponse->getExcerpt() ?? substr(strip_tags($articleResponse->getContent()), 0, 160),
            'article' => $articleResponse,
            'relatedArticles' => $relatedArticles,
            'themeManager' => $this->themeManager,
        ]);
    }

    public function loadMore(array $params = []): string
    {
        $page = $this->getParam('page', 2, 'int');
        $perPage = 6;
        $categoryId = $this->getParam('categoryId', null, 'int');

        if ($categoryId !== null) {
            // Handle category-specific articles
            $articles = $this->articleApplicationService->getArticlesByCategory(
                categoryId: $categoryId,
                limit: $perPage,
                offset: ($page - 1) * $perPage
            );

            if (empty($articles)) {
                return '<div class="no-more-articles">No more articles to load.</div>';
            }

            $isSvelteTheme = $this->themeManager->getCurrentTheme() === 'svelte';

            $html = '';
            foreach ($articles as $article) {
                $html .= $this->renderTemplate('partials/article-card.php', [
                    'article' => $article,
                    'isSvelteTheme' => $isSvelteTheme
                ]);
            }

            // Check if there are more articles by trying to fetch one more
            $nextArticles = $this->articleApplicationService->getArticlesByCategory(
                categoryId: $categoryId,
                limit: 1,
                offset: $page * $perPage
            );

            if (!empty($nextArticles)) {
                $nextPage = $page + 1;
                $html .= $this->renderTemplate('partials/load-more-button.php', [
                    'nextPage' => $nextPage,
                    'categoryId' => $categoryId
                ]);
            }
        } else {
            // Handle general articles
            $articlesResponse = $this->articleApplicationService->getArticles(
                page: $page,
                perPage: $perPage
            );

            if (empty($articlesResponse->getArticles())) {
                return '<div class="no-more-articles">No more articles to load.</div>';
            }

            $isSvelteTheme = $this->themeManager->getCurrentTheme() === 'svelte';

            $html = '';
            foreach ($articlesResponse->getArticles() as $article) {
                $html .= $this->renderTemplate('partials/article-card.php', [
                    'article' => $article,
                    'isSvelteTheme' => $isSvelteTheme
                ]);
            }

            // Add load more button if there are more articles
            if ($articlesResponse->hasMore()) {
                $nextPage = $page + 1;
                $html .= $this->renderTemplate('partials/load-more-button.php', [
                    'nextPage' => $nextPage,
                    'categoryId' => null
                ]);
            }
        }

        return $html;
    }

    public function category(array $params = []): string
    {
        $categoryId = (int) ($params['id'] ?? 0);

        if ($categoryId === 0) {
            return $this->notFound('Category Not Found');
        }

        $paginationRequest = PaginationRequest::fromGlobals();

        $articlesResponse = $this->articleApplicationService->getArticles(
            page: $paginationRequest->getPage(),
            perPage: 6,
            categoryId: $categoryId
        );

        // Get category name (simplified - in real app you'd have a CategoryService)
        $categoryName = $this->getCategoryName($categoryId);

        return $this->render('pages::articles', [
            'title' => $categoryName . ' Articles - Boson PHP',
            'description' => 'Articles in the ' . $categoryName . ' category',
            'articles' => $articlesResponse->getArticles(),
            'currentPage' => $articlesResponse->getCurrentPage(),
            'hasMore' => $articlesResponse->hasMore(),
            'categoryId' => $categoryId,
            'categoryName' => $categoryName
        ]);
    }

    private function renderArticleCard($article): string
    {
        $publishedDate = $article->getPublishedAt()?->format('M j, Y') ?? '';
        $excerpt = $article->getExcerpt() ?? substr(strip_tags($article->getContent()), 0, 150) . '...';

        return '
            <article class="article-card" data-article-id="' . $article->getId() . '">
                ' . ($article->getFeaturedImage() ?
                    '<div class="article-image">
                        <img src="' . htmlspecialchars($article->getFeaturedImage()) . '"
                             alt="' . htmlspecialchars($article->getTitle()) . '"
                             loading="lazy">
                    </div>' : '') . '
                <div class="article-content">
                    <div class="article-meta">
                        <time datetime="' . $article->getPublishedAt()?->format('Y-m-d') . '">' . $publishedDate . '</time>
                    </div>
                    <h2 class="article-title">
                        <a href="/articles/' . $article->getSlug() . '">' . htmlspecialchars($article->getTitle()) . '</a>
                    </h2>
                    <p class="article-excerpt">' . htmlspecialchars($excerpt) . '</p>
                    <a href="/articles/' . $article->getSlug() . '" class="read-more">Read More →</a>
                </div>
            </article>
        ';
    }

    private function renderSvelteArticleCard($article): string
    {
        $articleData = [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'slug' => $article->getSlug(),
            'excerpt' => $article->getExcerpt() ?? substr(strip_tags($article->getContent()), 0, 150),
            'content' => strip_tags($article->getContent()), // Remove HTML for JSON safety
            'image' => $article->getFeaturedImage(),
            'author' => 'Boson Team', // TODO: Load from authors table
            'category' => 'General', // TODO: Load from categories table
            'published_at' => $article->getPublishedAt()?->format('Y-m-d H:i:s')
        ];

        return '<div class="svelte-article-card" data-article="' . htmlspecialchars(json_encode($articleData), ENT_QUOTES, 'UTF-8') . '"></div>';
    }

    private function getCategoryName(int $categoryId): string
    {
        // TODO: Implement proper CategoryService
        $categoryNames = [
            1 => 'Architecture',
            2 => 'DDD',
            3 => 'Patterns',
            4 => 'PHP',
            5 => 'Testing'
        ];

        return $categoryNames[$categoryId] ?? 'Unknown Category';
    }
}
