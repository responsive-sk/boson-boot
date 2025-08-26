<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\Config;
use Boson\Shared\Infrastructure\Database;
use Boson\Shared\Infrastructure\ThemeManager;

class ArticleController
{
    public function __construct(
        private $templateEngine,
        private Database $database,
        private Config $config,
        private ArticleService $articleService,
        private ThemeManager $themeManager
    ) {}

    public function index(array $params = []): string
    {
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 6;

        $result = $this->articleService->getPaginatedArticles($page, $perPage);

        return $this->templateEngine->render('pages::articles', [
            'title' => 'Articles - Boson PHP',
            'description' => 'Read the latest articles about Boson PHP development',
            'articles' => $result['articles'],
            'currentPage' => $result['currentPage'],
            'totalPages' => $result['totalPages'],
            'hasMore' => $result['hasMore'],
            'total' => $result['total'],
            'currentRoute' => 'articles',
            'themeManager' => $this->themeManager
        ]);
    }

    public function show(array $params = []): string
    {
        $slug = $params['slug'] ?? '';
        
        if (empty($slug)) {
            http_response_code(404);
            return $this->templateEngine->render('pages::404', [
                'title' => 'Article Not Found - Boson PHP'
            ]);
        }

        $article = $this->articleService->getArticleBySlug($slug);

        if (!$article || !$article->isPublished()) {
            http_response_code(404);
            return $this->templateEngine->render('pages::404', [
                'title' => 'Article Not Found - Boson PHP'
            ]);
        }

        // Get related articles (same category, excluding current)
        $relatedArticles = [];
        if ($article->getCategoryId()) {
            $allRelated = $this->articleService->getArticlesByCategory($article->getCategoryId(), 4);
            $relatedArticles = array_filter($allRelated, fn($a) => $a->getId() !== $article->getId());
            $relatedArticles = array_slice($relatedArticles, 0, 3);
        }

        return $this->templateEngine->render('pages::article', [
            'title' => $article->getTitle() . ' - Boson PHP',
            'description' => $article->getExcerpt() ?? substr(strip_tags($article->getContent()), 0, 160),
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'currentRoute' => 'articles',
            'themeManager' => $this->themeManager
        ]);
    }

    public function loadMore(array $params = []): string
    {
        $page = (int) ($_GET['page'] ?? 2);
        $perPage = 6;

        $result = $this->articleService->getPaginatedArticles($page, $perPage);

        if (empty($result['articles'])) {
            return '<div class="no-more-articles">No more articles to load.</div>';
        }

        $html = '';
        foreach ($result['articles'] as $article) {
            $html .= $this->renderArticleCard($article);
        }

        // Add load more button if there are more articles
        if ($result['hasMore']) {
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
            http_response_code(404);
            return $this->templateEngine->render('pages::404', [
                'title' => 'Category Not Found - Boson PHP'
            ]);
        }

        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;

        $articles = $this->articleService->getArticlesByCategory($categoryId, $perPage + 1, $offset);
        $hasMore = count($articles) > $perPage;
        
        if ($hasMore) {
            array_pop($articles);
        }

        // Get category name (simplified - in real app you'd have a CategoryService)
        $categoryName = $this->getCategoryName($categoryId);

        return $this->templateEngine->render('pages::articles', [
            'title' => $categoryName . ' Articles - Boson PHP',
            'description' => 'Articles in the ' . $categoryName . ' category',
            'articles' => $articles,
            'currentPage' => $page,
            'hasMore' => $hasMore,
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
        $sql = "SELECT name FROM categories WHERE id = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$categoryId]);
        
        return $stmt->fetchColumn() ?: 'Unknown Category';
    }
}
