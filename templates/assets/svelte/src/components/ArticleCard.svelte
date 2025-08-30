<script>
  export let article
  
  let isHovered = false
  
  $: readingTime = calculateReadingTime(article.content || article.excerpt || '')
  
  function calculateReadingTime(text) {
    const wordsPerMinute = 200
    const words = text.split(' ').length
    return Math.ceil(words / wordsPerMinute)
  }
  
  function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  }
  
  function truncateText(text, maxLength = 150) {
    if (text.length <= maxLength) return text
    return text.substring(0, maxLength).trim() + '...'
  }
</script>

<article
  class="article-card card-svelte card-interactive animate-fade-in"
  class:hovered={isHovered}
  on:mouseenter={() => isHovered = true}
  on:mouseleave={() => isHovered = false}
>
  <a href="/articles/{article.slug}" class="card-link">
    <!-- Article Image (if available) -->
    {#if article.image}
      <div class="card-image">
        <img src={article.image} alt={article.title} loading="lazy" />
      </div>
    {/if}
    
    <!-- Card Content -->
    <div class="card-content">
      <!-- Category Badge -->
      {#if article.category}
        <div class="category-badge animate-slide-in-left">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
            <line x1="7" y1="7" x2="7.01" y2="7"/>
          </svg>
          {article.category}
        </div>
      {/if}
      
      <!-- Title -->
      <h3 class="card-title">
        {article.title}
      </h3>
      
      <!-- Excerpt -->
      {#if article.excerpt}
        <p class="card-excerpt">
          {truncateText(article.excerpt)}
        </p>
      {/if}
      
      <!-- Meta Information -->
      <div class="card-meta">
        <div class="meta-left">
          <!-- Author -->
          {#if article.author}
            <span class="author">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
              {article.author}
            </span>
          {/if}
          
          <!-- Published Date -->
          <span class="date">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            {formatDate(article.published_at)}
          </span>
        </div>
        
        <div class="meta-right">
          <!-- Reading Time -->
          <span class="reading-time">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12,6 12,12 16,14"/>
            </svg>
            {readingTime} min read
          </span>
        </div>
      </div>
      
      <!-- Read More Arrow -->
      <div class="read-more btn-svelte btn-outline btn-sm">
        <span>Read article</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="read-more-icon">
          <path d="M7 17L17 7M17 7H7M17 7V17"/>
        </svg>
      </div>
    </div>
  </a>
</article>

<style>
  .article-card {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .article-card:hover,
  .article-card.hovered {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
  }
  
  .card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  
  .card-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: var(--bg-secondary);
  }
  
  .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  
  .article-card:hover .card-image img {
    transform: scale(1.05);
  }
  
  .card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .category-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-1);
    background: linear-gradient(135deg, var(--primary-glow), rgba(249, 57, 4, 0.15));
    color: var(--primary);
    font-size: var(--font-size-xs);
    font-weight: 700;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    margin-bottom: var(--space-4);
    width: fit-content;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid rgba(249, 57, 4, 0.2);
    backdrop-filter: blur(10px);
    transition: all var(--transition-base);
  }

  .category-badge:hover {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: var(--text-inverse);
    transform: scale(1.05);
    box-shadow: var(--shadow-glow);
  }
  
  .card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 1rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .card-excerpt {
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0 0 1.5rem;
    flex: 1;
  }
  
  .card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.75rem;
    color: var(--text-muted);
  }
  
  .meta-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
  }
  
  .meta-right {
    flex-shrink: 0;
  }
  
  .author,
  .date,
  .reading-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    white-space: nowrap;
  }
  
  .author {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .read-more {
    margin-top: auto;
    align-self: flex-start;
  }

  .read-more-icon {
    transition: transform var(--transition-bounce);
  }

  .article-card:hover .read-more-icon {
    transform: translateX(4px) rotate(5deg);
  }

  .read-more:hover .read-more-icon {
    animation: svelte-bounce 0.6s ease-in-out;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .card-content {
      padding: 1rem;
    }
    
    .card-title {
      font-size: 1.125rem;
    }
    
    .card-meta {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.5rem;
    }
    
    .meta-left {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.5rem;
    }
    
    .meta-right {
      align-self: flex-start;
    }
  }
  
  /* Loading state */
  .article-card.loading {
    pointer-events: none;
  }
  
  .article-card.loading .card-content {
    opacity: 0.6;
  }
  
  /* Focus styles for accessibility */
  .card-link:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
  }
  
  /* High contrast mode support */
  @media (prefers-contrast: high) {
    .article-card {
      border-width: 2px;
    }
    
    .category-badge {
      border: 1px solid var(--primary);
    }
  }
  
  /* Reduced motion support */
  @media (prefers-reduced-motion: reduce) {
    .article-card,
    .card-image img,
    .read-more,
    .read-more svg {
      transition: none;
    }
    
    .article-card:hover {
      transform: none;
    }
    
    .article-card:hover .card-image img {
      transform: none;
    }
  }
</style>
