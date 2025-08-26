<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\Config;
use Boson\Shared\Infrastructure\Database;
use Boson\Shared\Infrastructure\Security\InputValidator;
use Boson\Shared\Infrastructure\Security\RateLimiter;
use Exception;

use function array_slice;
use function count;
use function strlen;

class SearchController
{
    public function __construct(
        private $templateEngine,
        private Database $database,
        private Config $config,
    ) {}

    public function index(array $params = []): string
    {
        $query   = $_GET['q'] ?? '';
        $results = [];

        if ($query) {
            $results = $this->performSearch($query);
        }

        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Search', 'url' => null],
        ];

        return $this->templateEngine->render('layout::default', [
            'title'        => $query ? "Search results for \"{$query}\"" : 'Search - Boson PHP',
            'description'  => 'Search documentation, blog posts, and examples.',
            'currentRoute' => 'search',
            'pageTitle'    => 'Search',
            'pageSubtitle' => $query ? "Results for \"{$query}\"" : 'Search documentation, blog posts, and examples',
            'breadcrumbs'  => $breadcrumbs,
            'content'      => $this->renderSearchResults($query, $results),
            'searchQuery'  => $query,
        ]);
    }

    public function search(array $params = []): string
    {
        // Handle POST search (redirect to GET)
        $query = $_POST['q'] ?? '';
        header('Location: /search?q=' . urlencode($query));
        exit;
    }

    public function apiSearch(array $params = []): string
    {
        // Rate limiting for search requests
        $rateLimiter = new RateLimiter();
        $identifier  = $rateLimiter->getClientIdentifier() . ':search';

        if (!$rateLimiter->isAllowed($identifier, 30, 300)) { // 30 searches per 5 minutes
            http_response_code(429);

            return '<div class="search-results-error">Too many search requests. Please wait a moment.</div>';
        }

        // HTMX API endpoint for live search results
        $query = $_GET['q'] ?? '';

        // Input validation
        $validator = new InputValidator();
        if (!$validator->validate(['q' => $query], [
            'q' => ['required', ['min', 2], ['max', 100], 'string'],
        ])) {
            return '<div class="search-results-empty">Type at least 2 characters to search...</div>';
        }

        // Sanitize input
        $query = InputValidator::sanitizeString($query);

        $rateLimiter->recordAttempt($identifier);
        $results = $this->performSearch($query);

        if (empty($results)) {
            return '<div class="search-results-empty">No results found for "' . htmlspecialchars($query) . '"</div>';
        }

        return $this->renderSearchResultsHtml($results);
    }

    private function performSearch(string $query): array
    {
        if (strlen($query) < $this->config->getSearchMinLength()) {
            return [];
        }

        $results    = [];
        $maxResults = $this->config->getSearchMaxResults();

        // Search articles using FTS
        $articleResults = $this->searchArticles($query, $maxResults);
        foreach ($articleResults as $article) {
            $results[] = [
                'type'         => 'article',
                'title'        => $article['title'],
                'url'          => '/articles/' . $article['slug'],
                'excerpt'      => $this->highlightSearchTerms($article['excerpt'] ?? '', $query),
                'category'     => $article['category'] ?? 'Article',
                'published_at' => $article['published_at'],
            ];
        }

        // Add mock documentation results (can be replaced with real docs search later)
        if (count($results) < $maxResults) {
            $docResults = $this->searchDocumentation($query, $maxResults - count($results));
            $results    = array_merge($results, $docResults);
        }

        return array_slice($results, 0, $maxResults);
    }

    private function searchArticles(string $query, int $limit): array
    {
        // Use SQLite FTS for articles
        $sql = "
            SELECT
                a.title, a.slug, a.excerpt, a.published_at,
                c.name as category
            FROM articles_fts
            JOIN articles a ON articles_fts.rowid = a.id
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE articles_fts MATCH ? AND a.status = 'published'
            ORDER BY rank
            LIMIT ?
        ";

        try {
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([$query, $limit]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Fallback to LIKE search if FTS fails
            return $this->fallbackArticleSearch($query, $limit);
        }
    }

    private function fallbackArticleSearch(string $query, int $limit): array
    {
        $sql = "
            SELECT
                a.title, a.slug, a.excerpt, a.published_at,
                c.name as category
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE (a.title LIKE ? OR a.excerpt LIKE ? OR a.content LIKE ?)
            AND a.status = 'published'
            ORDER BY a.published_at DESC
            LIMIT ?
        ";

        $searchTerm = '%' . $query . '%';
        $stmt       = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit]);

        return $stmt->fetchAll();
    }

    private function searchDocumentation(string $query, int $limit): array
    {
        // Mock documentation search - replace with real implementation
        $docs = [
            [
                'type'     => 'documentation',
                'title'    => 'Installation Guide',
                'url'      => '/docs/latest/installation',
                'excerpt'  => 'Learn how to install Boson PHP on your system...',
                'category' => 'Getting Started',
            ],
            [
                'type'     => 'documentation',
                'title'    => 'Building Your First App',
                'url'      => '/docs/latest/first-app',
                'excerpt'  => 'Create your first desktop application with Boson PHP...',
                'category' => 'Tutorial',
            ],
        ];

        $results    = [];
        $queryLower = strtolower($query);

        foreach ($docs as $doc) {
            if (
                strpos(strtolower($doc['title']), $queryLower) !== false
                || strpos(strtolower($doc['excerpt']), $queryLower) !== false
            ) {
                $results[] = $doc;
                if (count($results) >= $limit) {
                    break;
                }
            }
        }

        return $results;
    }

    private function highlightSearchTerms(string $text, string $query): string
    {
        if (empty($text) || empty($query)) {
            return $text;
        }

        $words = explode(' ', $query);
        foreach ($words as $word) {
            if (strlen($word) >= 2) {
                $text = preg_replace(
                    '/(' . preg_quote($word, '/') . ')/i',
                    '<mark>$1</mark>',
                    $text,
                );
            }
        }

        return $text;
    }

    private function renderSearchResults(string $query, array $results): string
    {
        $html = '<div class="search-page">';

        if ($query && !empty($results)) {
            $html .= '<div class="search-summary">';
            $html .= '<p>Found ' . count($results) . ' result' . (count($results) !== 1 ? 's' : '') . ' for "' . htmlspecialchars($query) . '"</p>';
            $html .= '</div>';
        }

        if (!empty($results)) {
            $html .= $this->renderSearchResultsHtml($results);
        } elseif ($query) {
            $html .= '<div class="search-results-empty">';
            $html .= '<p>No results found for "' . htmlspecialchars($query) . '"</p>';
            $html .= '<p>Try different keywords or check the spelling.</p>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    private function renderSearchResultsHtml(array $results): string
    {
        $html = '<div class="search-results">';

        foreach ($results as $result) {
            $html .= '<div class="search-result">';
            $html .= '<div class="result-type">' . ucfirst($result['type']) . '</div>';
            $html .= '<h3><a href="' . $result['url'] . '">' . htmlspecialchars($result['title']) . '</a></h3>';
            $html .= '<p class="result-excerpt">' . htmlspecialchars($result['excerpt']) . '</p>';
            $html .= '<div class="result-meta">';
            $html .= '<span class="result-category">' . htmlspecialchars($result['category']) . '</span>';
            $html .= '<span class="result-url">' . $result['url'] . '</span>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}
