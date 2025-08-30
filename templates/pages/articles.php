<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => 'articles',
    'pageTitle' => 'Articles',
    'pageSubtitle' => 'Discover insights, tutorials, and updates about Boson PHP development',
    'themeManager' => $themeManager ?? null
]) ?>

<?php $this->start('main') ?>

<div class="articles-page">
    <div class="container">

        <!-- Articles Grid -->
        <div class="articles-grid" id="articles-container">
            <?php if (isset($themeManager) && $themeManager->getCurrentTheme() === 'svelte'): ?>
                <!-- Svelte Components -->
                <?php foreach ($articles as $article): ?>
                    <div class="svelte-article-card"
                         data-article="<?= htmlspecialchars(json_encode([
                             'id' => $article->getId(),
                             'title' => $article->getTitle(),
                             'slug' => $article->getSlug(),
                             'excerpt' => $article->getExcerpt() ?? $this->truncate(strip_tags($article->getContent()), 150),
                             'content' => strip_tags($article->getContent()), // Remove HTML for JSON safety
                             'image' => $article->getFeaturedImage(),
                             'author' => 'Boson Team', // TODO: Load from authors table
                             'category' => 'General', // TODO: Load from categories table
                             'published_at' => $article->getPublishedAt()?->format('Y-m-d H:i:s')
                         ]), ENT_QUOTES, 'UTF-8') ?>"></div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Static HTML Cards -->
                <?php foreach ($articles as $article): ?>
                    <article class="article-card" data-article-id="<?= $article->getId() ?>">
                        <?php if ($article->getFeaturedImage()): ?>
                            <div class="article-image">
                                <img src="<?= $this->escapeHtml($article->getFeaturedImage()) ?>"
                                     alt="<?= $this->escapeHtml($article->getTitle()) ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>

                        <div class="article-content">
                            <div class="article-meta">
                                <time datetime="<?= $article->getPublishedAt()?->format('Y-m-d') ?>">
                                    <?= $article->getPublishedAt()?->format('M j, Y') ?>
                                </time>
                            </div>

                            <h2 class="article-title">
                                <a href="/articles/<?= $article->getSlug() ?>">
                                    <?= $this->escapeHtml($article->getTitle()) ?>
                                </a>
                            </h2>

                            <p class="article-excerpt">
                                <?= $this->escapeHtml($article->getExcerpt() ?? $this->truncate(strip_tags($article->getContent()), 150)) ?>
                            </p>

                            <a href="/articles/<?= $article->getSlug() ?>" class="read-more">
                                Read More →
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Load More Button -->
        <?php if ($hasMore ?? false): ?>
            <div class="load-more-container" id="load-more-container">
                <button
                    class="btn btn-outline load-more-btn"
                    hx-get="/api/articles/load-more?page=<?= ($currentPage ?? 1) + 1 ?><?= isset($categoryId) ? '&categoryId=' . $categoryId : '' ?>"
                    hx-target="#articles-container"
                    hx-swap="beforeend"
                    hx-indicator="#loading-indicator"
                >
                    Load More Articles
                </button>
                
                <div id="loading-indicator" class="loading-indicator htmx-indicator">
                    <div class="spinner"></div>
                    <span>Loading more articles...</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Empty State -->
        <?php if (empty($articles)): ?>
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>No Articles Yet</h3>
                <p>We're working on creating great content for you. Check back soon!</p>
            </div>
        <?php endif; ?>

        <!-- Pagination Info -->
        <?php if (!empty($articles)): ?>
            <div class="pagination-info">
                <p>
                    Showing <?= count($articles) ?> of <?= $total ?? 0 ?> articles
                    <?php if (isset($categoryName)): ?>
                        in <strong><?= $this->escapeHtml($categoryName) ?></strong>
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->stop() ?>

<style>
.articles-page {
    padding: 2rem 0 4rem;
    min-height: 60vh;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.article-card {
    background: var(--surface);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid var(--border);
}

.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
}

.article-image {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-image img {
    transform: scale(1.05);
}

.article-content {
    padding: 1.5rem;
}

.article-meta {
    margin-bottom: 0.75rem;
}

.article-meta time {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.article-title {
    margin-bottom: 0.75rem;
}

.article-title a {
    color: var(--text-primary);
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.2s ease;
}

.article-title a:hover {
    color: var(--primary);
}

.article-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.read-more {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: color 0.2s ease;
}

.read-more:hover {
    color: var(--primary-dark);
}

.load-more-container {
    text-align: center;
    margin: 2rem 0;
}

.load-more-btn {
    padding: 0.75rem 2rem;
    font-weight: 500;
}

.loading-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    color: var(--text-secondary);
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border);
    border-top: 2px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-secondary);
}

.pagination-info {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.pagination-info p {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .articles-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .article-content {
        padding: 1.25rem;
    }
}
</style>
