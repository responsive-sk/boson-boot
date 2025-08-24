<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\TemplateEngine;
use Boson\Shared\Infrastructure\Database;
use Boson\Shared\Infrastructure\Config;

class BlogController
{
    public function __construct(
        private $templateEngine,
        private Database $database,
        private Config $config,
        private BlogService $blogService
    ) {}

    public function index(array $params = []): string
    {
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = $this->config->getBlogPostsPerPage();
        $offset = ($page - 1) * $perPage;

        // Get published blog posts from database
        $sql = "
            SELECT
                bp.id, bp.title, bp.slug, bp.excerpt, bp.published_at,
                c.name as category,
                u.name as author
            FROM blog_posts bp
            LEFT JOIN categories c ON bp.category_id = c.id
            LEFT JOIN users u ON bp.author_id = u.id
            WHERE bp.status = 'published'
            ORDER BY bp.published_at DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        $posts = $stmt->fetchAll();

        // Get total count for pagination
        $countSql = "SELECT COUNT(*) FROM blog_posts WHERE status = 'published'";
        $totalPosts = $this->database->getConnection()->query($countSql)->fetchColumn();
        $totalPages = (int) ceil($totalPosts / $perPage);

        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Blog', 'url' => null]
        ];

        return $this->templateEngine->render('layout::default', [
            'title' => 'Blog - Boson PHP',
            'description' => 'Latest news, tutorials, and insights about Boson PHP desktop development.',
            'currentRoute' => 'blog.index',
            'pageTitle' => 'Blog',
            'pageSubtitle' => 'Latest news, tutorials, and insights about desktop development with PHP',
            'breadcrumbs' => $breadcrumbs,
            'content' => $this->renderBlogIndex($posts, $page, $totalPages)
        ]);
    }

    public function show(array $params = []): string
    {
        $slug = $params['slug'] ?? '';

        // Get blog post from database
        $sql = "
            SELECT
                bp.id, bp.title, bp.slug, bp.content, bp.excerpt, bp.published_at,
                c.name as category,
                u.name as author
            FROM blog_posts bp
            LEFT JOIN categories c ON bp.category_id = c.id
            LEFT JOIN users u ON bp.author_id = u.id
            WHERE bp.slug = ? AND bp.status = 'published'
        ";

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$slug]);
        $post = $stmt->fetch();

        if (!$post) {
            // Return 404 page or redirect
            return $this->templateEngine->render('layout::default', [
                'title' => 'Post Not Found - Blog - Boson PHP',
                'pageTitle' => 'Post Not Found',
                'content' => '<p>The requested blog post was not found.</p>'
            ]);
        }

        $breadcrumbs = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Blog', 'url' => '/blog'],
            ['text' => $post['title'], 'url' => null]
        ];

        return $this->templateEngine->render('layout::default', [
            'title' => $post['title'] . ' - Blog - Boson PHP',
            'description' => 'Learn how to build your first desktop application with PHP using Boson.',
            'currentRoute' => 'blog.show',
            'pageTitle' => $post['title'],
            'pageSubtitle' => 'Published on ' . date('F j, Y', strtotime($post['published_at'])) . ' by ' . $post['author'],
            'breadcrumbs' => $breadcrumbs,
            'content' => $post['content']
        ]);
    }

    public function loadMore(array $params = []): string
    {
        // HTMX endpoint for loading more blog posts
        $offset = (int)($_GET['offset'] ?? 0);
        $limit = $this->config->getBlogPostsPerPage();

        $sql = "
            SELECT
                bp.id, bp.title, bp.slug, bp.excerpt, bp.published_at,
                c.name as category,
                u.name as author
            FROM blog_posts bp
            LEFT JOIN categories c ON bp.category_id = c.id
            LEFT JOIN users u ON bp.author_id = u.id
            WHERE bp.status = 'published'
            ORDER BY bp.published_at DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$limit, $offset]);
        $posts = $stmt->fetchAll();

        return $this->renderBlogPosts($posts);
    }

    private function renderBlogIndex(array $posts, int $currentPage, int $totalPages): string
    {
        $html = '<div class="blog-posts">';
        $html .= $this->renderBlogPosts($posts);
        $html .= '</div>';

        // Add pagination
        if ($totalPages > 1) {
            $html .= '<div class="pagination-container">';
            $html .= $this->renderPagination($currentPage, $totalPages);
            $html .= '</div>';
        }

        // Add HTMX load more for first page
        if ($currentPage === 1 && $totalPages > 1) {
            $nextOffset = $this->config->getBlogPostsPerPage();
            $html .= '<div class="load-more-container">';
            $html .= '<button class="btn btn-secondary" hx-get="/api/blog/load-more?offset=' . $nextOffset . '" hx-target=".blog-posts" hx-swap="beforeend" hx-remove="this">';
            $html .= 'Load More Posts</button>';
            $html .= '</div>';
        }

        return $html;
    }

    private function renderBlogPosts(array $posts): string
    {
        $html = '';
        foreach ($posts as $post) {
            $html .= '<article class="blog-post">';
            $html .= '<h2><a href="/blog/' . $post['slug'] . '">' . htmlspecialchars($post['title']) . '</a></h2>';
            $html .= '<div class="post-meta">';
            $html .= '<span class="post-date">' . date('F j, Y', strtotime($post['published_at'])) . '</span>';
            $html .= '<span class="post-author">by ' . htmlspecialchars($post['author']) . '</span>';
            $html .= '<span class="post-category">' . htmlspecialchars($post['category']) . '</span>';
            $html .= '</div>';
            $html .= '<p class="post-excerpt">' . htmlspecialchars($post['excerpt']) . '</p>';
            $html .= '<a href="/blog/' . $post['slug'] . '" class="read-more">Read More →</a>';
            $html .= '</article>';
        }
        return $html;
    }

    private function renderPagination(int $currentPage, int $totalPages): string
    {
        $html = '<nav class="pagination" aria-label="Blog pagination">';
        $html .= '<ul class="pagination-list">';

        // Previous page
        if ($currentPage > 1) {
            $html .= '<li><a href="/blog?page=' . ($currentPage - 1) . '" class="pagination-link">← Previous</a></li>';
        }

        // Page numbers
        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);

        if ($start > 1) {
            $html .= '<li><a href="/blog?page=1" class="pagination-link">1</a></li>';
            if ($start > 2) {
                $html .= '<li><span class="pagination-ellipsis">...</span></li>';
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i === $currentPage) {
                $html .= '<li><span class="pagination-link current">' . $i . '</span></li>';
            } else {
                $html .= '<li><a href="/blog?page=' . $i . '" class="pagination-link">' . $i . '</a></li>';
            }
        }

        if ($end < $totalPages) {
            if ($end < $totalPages - 1) {
                $html .= '<li><span class="pagination-ellipsis">...</span></li>';
            }
            $html .= '<li><a href="/blog?page=' . $totalPages . '" class="pagination-link">' . $totalPages . '</a></li>';
        }

        // Next page
        if ($currentPage < $totalPages) {
            $html .= '<li><a href="/blog?page=' . ($currentPage + 1) . '" class="pagination-link">Next →</a></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }
}
