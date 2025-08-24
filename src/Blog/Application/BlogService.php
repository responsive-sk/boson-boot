<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Blog\Domain\BlogPost;
use Boson\Blog\Domain\BlogPostRepository;
use Boson\Blog\Domain\BlogPostStatus;

class BlogService
{
    public function __construct(
        private BlogPostRepository $blogPostRepository
    ) {}

    public function getPublishedPosts(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $posts = $this->blogPostRepository->findPublished($perPage, $offset);
        $totalPosts = $this->blogPostRepository->countByStatus(BlogPostStatus::PUBLISHED);
        $totalPages = (int) ceil($totalPosts / $perPage);

        return [
            'posts' => $posts,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_posts' => $totalPosts,
                'total_pages' => $totalPages,
                'has_next' => $page < $totalPages,
                'has_previous' => $page > 1
            ]
        ];
    }

    public function getPostBySlug(string $slug): ?BlogPost
    {
        $post = $this->blogPostRepository->findBySlug($slug);
        
        // Only return published posts for public access
        if ($post && !$post->isPublished()) {
            return null;
        }
        
        return $post;
    }

    public function searchPosts(string $query, int $limit = 10): array
    {
        if (strlen($query) < 2) {
            return [];
        }

        return $this->blogPostRepository->search($query, $limit);
    }

    public function createPost(
        string $title,
        string $content,
        int $authorId,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): BlogPost {
        $slug = $this->generateUniqueSlug($title);
        
        $post = BlogPost::create(
            title: $title,
            slug: $slug,
            content: $content,
            authorId: $authorId,
            excerpt: $excerpt,
            featuredImage: $featuredImage,
            categoryId: $categoryId
        );

        return $this->blogPostRepository->save($post);
    }

    public function updatePost(
        int $id,
        string $title,
        string $content,
        ?string $excerpt = null,
        ?string $featuredImage = null,
        ?int $categoryId = null
    ): ?BlogPost {
        $post = $this->blogPostRepository->findById($id);
        
        if (!$post) {
            return null;
        }

        // Generate new slug if title changed
        $newSlug = $this->generateSlugFromTitle($title);
        if ($newSlug !== $post->getSlug()) {
            $newSlug = $this->generateUniqueSlug($title, $id);
        }

        $post->updateContent(
            title: $title,
            content: $content,
            excerpt: $excerpt,
            featuredImage: $featuredImage,
            categoryId: $categoryId
        );

        return $this->blogPostRepository->save($post);
    }

    public function publishPost(int $id): ?BlogPost
    {
        $post = $this->blogPostRepository->findById($id);
        
        if (!$post) {
            return null;
        }

        $post->publish();
        return $this->blogPostRepository->save($post);
    }

    public function unpublishPost(int $id): ?BlogPost
    {
        $post = $this->blogPostRepository->findById($id);
        
        if (!$post) {
            return null;
        }

        $post->unpublish();
        return $this->blogPostRepository->save($post);
    }

    public function archivePost(int $id): ?BlogPost
    {
        $post = $this->blogPostRepository->findById($id);
        
        if (!$post) {
            return null;
        }

        $post->archive();
        return $this->blogPostRepository->save($post);
    }

    public function deletePost(int $id): bool
    {
        return $this->blogPostRepository->delete($id);
    }

    public function getPostsByStatus(BlogPostStatus $status, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $posts = $this->blogPostRepository->findByStatus($status, $perPage, $offset);
        $totalPosts = $this->blogPostRepository->countByStatus($status);
        $totalPages = (int) ceil($totalPosts / $perPage);

        return [
            'posts' => $posts,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_posts' => $totalPosts,
                'total_pages' => $totalPages,
                'has_next' => $page < $totalPages,
                'has_previous' => $page > 1
            ]
        ];
    }

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = $this->generateSlugFromTitle($title);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->blogPostRepository->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function generateSlugFromTitle(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
