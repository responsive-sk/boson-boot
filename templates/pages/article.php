<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => 'articles',
    'breadcrumbs' => [
        ['text' => 'Home', 'url' => '/'],
        ['text' => 'Articles', 'url' => '/articles'],
        ['text' => $article->getTitle(), 'url' => null]
    ]
]) ?>

<?php $this->start('main') ?>

<?php if (isset($themeManager) && $themeManager->getCurrentTheme() === 'svelte'): ?>
  <div id="svelte-article-detail" data-article='<?= json_encode([
      'id' => $article->getId(),
      'title' => $article->getTitle(),
      'slug' => $article->getSlug(),
      'excerpt' => $article->getExcerpt(),
      'content' => $article->getContent(),
      'featuredImage' => $article->getFeaturedImage(),
      'publishedAt' => $article->getPublishedAt()?->format('Y-m-d'),
      'publishedAtFormatted' => $article->getPublishedAt()?->format('F j, Y'),
      'author' => $article->getAuthorId() ? [
          'id' => $article->getAuthorId(),
          'name' => 'Author Name' // This would need to be fetched from user data
      ] : null,
      'category' => $article->getCategoryId() ? [
          'id' => $article->getCategoryId(),
          'name' => 'Category Name' // This would need to be fetched from category data
      ] : null,
      'tags' => [], // Article domain doesn't have tags yet
      'status' => $article->getStatus(),
      'createdAt' => $article->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updatedAt' => $article->getUpdatedAt()?->format('Y-m-d H:i:s'),
      'publishedAt' => $article->getPublishedAt()?->format('Y-m-d H:i:s')
  ]) ?>'></div>
  <script type="module" src="<?= $themeManager->getJsUrl() ?>"></script>
<?php else: ?>
  <article class="article-page">
      <div class="container">
          <!-- Article Header -->
          <header class="article-header">
              <?php if ($article->getFeaturedImage()): ?>
                  <div class="article-featured-image">
                      <img src="<?= $this->escapeHtml($article->getFeaturedImage()) ?>" 
                           alt="<?= $this->escapeHtml($article->getTitle()) ?>">
                  </div>
              <?php endif; ?>
              
              <div class="article-meta">
                  <time datetime="<?= $article->getPublishedAt()?->format('Y-m-d') ?>">
                      <?= $article->getPublishedAt()?->format('F j, Y') ?>
                  </time>
                  <span class="reading-time">5 min read</span>
              </div>
              
              <h1 class="article-title"><?= $this->escapeHtml($article->getTitle()) ?></h1>
              
              <?php if ($article->getExcerpt()): ?>
                  <div class="article-excerpt">
                      <?= $this->escapeHtml($article->getExcerpt()) ?>
                  </div>
              <?php endif; ?>
          </header>

          <!-- Article Content -->
          <div class="article-content">
              <?= $article->getContent() ?>
          </div>

          <!-- Article Footer -->
          <footer class="article-footer">
              <div class="article-actions">
                  <button class="btn btn-outline" onclick="window.history.back()">
                      ← Back to Articles
                  </button>
                  
                  <div class="share-buttons">
                      <span>Share:</span>
                      <a href="#" class="share-btn" data-share="twitter">Twitter</a>
                      <a href="#" class="share-btn" data-share="linkedin">LinkedIn</a>
                      <a href="#" class="share-btn" data-share="copy">Copy Link</a>
                  </div>
              </div>
          </footer>

          <!-- Related Articles -->
          <?php if (!empty($relatedArticles)): ?>
              <section class="related-articles">
                  <h2>Related Articles</h2>
                  <div class="related-grid">
                      <?php foreach ($relatedArticles as $related): ?>
                          <article class="related-card">
                              <?php if ($related->getFeaturedImage()): ?>
                                  <div class="related-image">
                                      <img src="<?= $this->escapeHtml($related->getFeaturedImage()) ?>" 
                                           alt="<?= $this->escapeHtml($related->getTitle()) ?>" 
                                           loading="lazy">
                                  </div>
                              <?php endif; ?>
                              
                              <div class="related-content">
                                  <time datetime="<?= $related->getPublishedAt()?->format('Y-m-d') ?>">
                                      <?= $related->getPublishedAt()?->format('M j, Y') ?>
                                  </time>
                                  
                                  <h3>
                                      <a href="/articles/<?= $related->getSlug() ?>">
                                          <?= $this->escapeHtml($related->getTitle()) ?>
                                      </a>
                                  </h3>
                                  
                                  <p>
                                      <?= $this->escapeHtml($this->truncate(strip_tags($related->getContent()), 100)) ?>
                                  </p>
                              </div>
                          </article>
                      <?php endforeach; ?>
                  </div>
              </section>
          <?php endif; ?>
      </div>
  </article>
<?php endif; ?>

<style>
.article-page {
    padding: 2rem 0 4rem;
}

.article-header {
    margin-bottom: 3rem;
    text-align: center;
}

.article-featured-image {
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
}

.article-featured-image img {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: cover;
}

.article-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.article-meta time {
    font-weight: 500;
}

.reading-time {
    position: relative;
    padding-left: 1rem;
}

.reading-time::before {
    content: '•';
    position: absolute;
    left: 0.5rem;
}

.article-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
    margin-bottom: 1.5rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.article-excerpt {
    font-size: 1.125rem;
    color: var(--text-secondary);
    line-height: 1.6;
    max-width: 700px;
    margin: 0 auto;
}

.article-content {
    max-width: 700px;
    margin: 0 auto;
    font-size: 1.125rem;
    line-height: 1.7;
    color: var(--text-primary);
}

.article-content h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 2.5rem 0 1rem;
    color: var(--text-primary);
}

.article-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 2rem 0 1rem;
    color: var(--text-primary);
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content blockquote {
    border-left: 4px solid var(--primary);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: var(--text-secondary);
}

.article-content code {
    background: var(--surface-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-family: 'Fira Code', monospace;
    font-size: 0.875em;
}

.article-content pre {
    background: var(--surface-secondary);
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.article-content pre code {
    background: none;
    padding: 0;
}

.article-footer {
    max-width: 700px;
    margin: 3rem auto 0;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.article-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.share-buttons {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
}

.share-buttons span {
    color: var(--text-secondary);
    font-weight: 500;
}

.share-btn {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.share-btn:hover {
    color: var(--primary-dark);
}

.related-articles {
    max-width: 1000px;
    margin: 4rem auto 0;
    padding-top: 3rem;
    border-top: 1px solid var(--border);
}

.related-articles h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 2rem;
    text-align: center;
    color: var(--text-primary);
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.related-card {
    background: var(--surface);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    border: 1px solid var(--border);
}

.related-card:hover {
    transform: translateY(-2px);
}

.related-image {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-content {
    padding: 1.25rem;
}

.related-content time {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.related-content h3 {
    margin: 0.5rem 0;
}

.related-content h3 a {
    color: var(--text-primary);
    text-decoration: none;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.2s ease;
}

.related-content h3 a:hover {
    color: var(--primary);
}

.related-content p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    line-height: 1.5;
    margin: 0;
}

@media (max-width: 768px) {
    .article-title {
        font-size: 2rem;
    }
    
    .article-content {
        font-size: 1rem;
    }
    
    .article-actions {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }
    
    .share-buttons {
        justify-content: center;
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Share functionality
document.addEventListener('DOMContentLoaded', function() {
    const shareButtons = document.querySelectorAll('.share-btn');
    
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const shareType = this.dataset.share;
            const url = window.location.href;
            const title = document.querySelector('.article-title').textContent;
            
            switch(shareType) {
                case 'twitter':
                    window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank');
                    break;
                case 'linkedin':
                    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank');
                    break;
                case 'copy':
                    navigator.clipboard.writeText(url).then(() => {
                        this.textContent = 'Copied!';
                        setTimeout(() => {
                            this.textContent = 'Copy Link';
                        }, 2000);
                    });
                    break;
            }
        });
    });
});
</script>

<?php $this->stop() ?>
