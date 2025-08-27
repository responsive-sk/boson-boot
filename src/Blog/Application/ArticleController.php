<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\AbstractController;
use Boson\Blog\Application\Service\ArticleApplicationService;
use Boson\Shared\Presentation\Request\PaginationRequest;

class ArticleController extends AbstractController
{
    private ArticleApplicationService $articleApplicationService;

    public function setArticleApplicationService(ArticleApplicationService $articleApplicationService): void
    {
        $this->articleApplicationService = $articleApplicationService;
    }

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

        if (!$articleResponse) {
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
        ]);
    }

    public function loadMore(array $params = []): string
    {
        $page = $this->getParam('page', 2, 'int');
        $perPage = 6;

        $articlesResponse = $this->articleApplicationService->getArticles(
            page: $page,
            perPage: $perPage
        );

        if (empty($articlesResponse->getArticles())) {
            return '<div class="no-more-articles">No more articles to load.</div>';
        }

        $html = '';
        foreach ($articlesResponse->getArticles() as $article) {
            $html .= $this->renderArticleCard($article);
        }

        // Add load more button if there are more articles
        if ($articlesResponse->hasMore()) {
            $nextPage = $page + 1;
            $html .= '
                <div class="load-more-container" id="load-more-container">
                    <button
                        class="btn btn-outline load-more-btn"
                        hx-get="/api/articles/load-more?page=' . $nextPage . '"
                        hx-target="#articles-container"
                        hx-swap="beforeend"
                        hx-indicator="#loading-indicator"
                    >
                        Load More Articles
                    </button>
                </div>
            ';
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
