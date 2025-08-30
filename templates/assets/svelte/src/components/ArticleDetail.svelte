<script>
  import { onMount } from 'svelte'

  export let article

  let isLoading = true
  let readingTime = 0
  let shareUrl = ''
  let shareTitle = ''

  onMount(() => {
    // Calculate reading time
    readingTime = calculateReadingTime(article.content || '')

    // Set share data
    shareUrl = window.location.href
    shareTitle = article.title

    // Simulate loading completion
    setTimeout(() => {
      isLoading = false
    }, 100)
  })

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

  function handleShare(platform) {
    const url = encodeURIComponent(shareUrl)
    const title = encodeURIComponent(shareTitle)

    switch(platform) {
      case 'twitter':
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank')
        break
      case 'linkedin':
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank')
        break
      case 'copy':
        navigator.clipboard.writeText(shareUrl).then(() => {
          // Could show a toast notification here
          console.log('Link copied to clipboard')
        })
        break
    }
  }

  function goBack() {
    window.history.back()
  }
</script>

<article class="article-detail svelte-component" class:loading={isLoading}>
  <!-- Article Header -->
  <header class="article-header animate-fade-in">
    {#if article.featuredImage}
      <div class="article-featured-image">
        <img
          src={article.featuredImage}
          alt={article.title}
          loading="lazy"
          class="animate-fade-in"
        />
      </div>
    {/if}

    <div class="article-meta">
      <time datetime={article.publishedAt} class="publish-date">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        {article.publishedAtFormatted || formatDate(article.publishedAt)}
      </time>

      <span class="reading-time">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12,6 12,12 16,14"/>
        </svg>
        {readingTime} min read
      </span>
    </div>

    <h1 class="article-title animate-slide-in-left">
      {article.title}
    </h1>

    {#if article.excerpt}
      <div class="article-excerpt animate-slide-in-right">
        {article.excerpt}
      </div>
    {/if}
  </header>

  <!-- Article Content -->
  <div class="article-content animate-fade-in" class:loaded={!isLoading}>
    {@html article.content}
  </div>

  <!-- Article Footer -->
  <footer class="article-footer animate-fade-in">
    <div class="article-actions">
      <button class="btn-svelte btn-outline btn-lg" on:click={goBack}>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Back to Articles
      </button>

      <div class="share-section">
        <span class="share-label">Share:</span>
        <div class="share-buttons">
          <button
            class="share-btn btn-svelte btn-ghost btn-sm"
            on:click={() => handleShare('twitter')}
            aria-label="Share on Twitter"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
          </button>

          <button
            class="share-btn btn-svelte btn-ghost btn-sm"
            on:click={() => handleShare('linkedin')}
            aria-label="Share on LinkedIn"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </button>

          <button
            class="share-btn btn-svelte btn-ghost btn-sm"
            on:click={() => handleShare('copy')}
            aria-label="Copy link"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </footer>
</article>

<style>
  .article-detail {
    max-width: 800px;
    margin: 0 auto;
    padding: var(--space-8) var(--space-6);
  }

  .article-detail.loading {
    opacity: 0.7;
    pointer-events: none;
  }

  .article-header {
    margin-bottom: var(--space-8);
    text-align: center;
  }

  .article-featured-image {
    margin-bottom: var(--space-6);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    position: relative;
  }

  .article-featured-image img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
    transition: transform var(--transition-slow);
  }

  .article-featured-image:hover img {
    transform: scale(1.02);
  }

  .article-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-6);
    margin-bottom: var(--space-6);
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    flex-wrap: wrap;
  }

  .publish-date,
  .reading-time {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-weight: 500;
  }

  .article-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.1;
    margin-bottom: var(--space-6);
    max-width: 100%;
  }

  .article-excerpt {
    font-size: var(--font-size-lg);
    color: var(--text-secondary);
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto var(--space-8);
    font-style: italic;
  }

  .article-content {
    font-size: var(--font-size-lg);
    line-height: 1.8;
    color: var(--text-primary);
    opacity: 0;
    transform: translateY(20px);
    transition: all var(--transition-base);
  }

  .article-content.loaded {
    opacity: 1;
    transform: translateY(0);
  }

  .article-content :global(h2) {
    font-size: 1.875rem;
    font-weight: 700;
    margin: var(--space-8) 0 var(--space-4);
    color: var(--text-primary);
    line-height: 1.2;
  }

  .article-content :global(h3) {
    font-size: 1.5rem;
    font-weight: 600;
    margin: var(--space-6) 0 var(--space-3);
    color: var(--text-primary);
    line-height: 1.3;
  }

  .article-content :global(p) {
    margin-bottom: var(--space-6);
  }

  .article-content :global(ul),
  .article-content :global(ol) {
    margin-bottom: var(--space-6);
    padding-left: var(--space-6);
  }

  .article-content :global(li) {
    margin-bottom: var(--space-3);
    line-height: 1.6;
  }

  .article-content :global(blockquote) {
    border-left: 4px solid var(--primary);
    padding-left: var(--space-6);
    margin: var(--space-8) 0;
    font-style: italic;
    color: var(--text-secondary);
    background: var(--bg-secondary);
    padding: var(--space-4) var(--space-6);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--primary);
  }

  .article-content :global(code) {
    background: var(--bg-secondary);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
    font-family: var(--font-mono);
    font-size: 0.875em;
    color: var(--text-primary);
  }

  .article-content :global(pre) {
    background: var(--bg-secondary);
    padding: var(--space-6);
    border-radius: var(--radius-lg);
    overflow-x: auto;
    margin: var(--space-6) 0;
    border: 1px solid var(--border);
  }

  .article-content :global(pre code) {
    background: none;
    padding: 0;
    font-size: 0.875em;
    line-height: 1.5;
  }

  .article-footer {
    margin-top: var(--space-12);
    padding-top: var(--space-8);
    border-top: 1px solid var(--border);
  }

  .article-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--space-4);
  }

  .share-section {
    display: flex;
    align-items: center;
    gap: var(--space-4);
  }

  .share-label {
    color: var(--text-secondary);
    font-weight: 500;
    font-size: var(--font-size-sm);
  }

  .share-buttons {
    display: flex;
    align-items: center;
    gap: var(--space-2);
  }

  .share-btn {
    transition: all var(--transition-fast);
  }

  .share-btn:hover {
    transform: translateY(-2px);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .article-detail {
      padding: var(--space-6) var(--space-4);
    }

    .article-meta {
      flex-direction: column;
      gap: var(--space-3);
    }

    .article-title {
      font-size: 2rem;
    }

    .article-actions {
      flex-direction: column;
      align-items: stretch;
      text-align: center;
    }

    .share-section {
      justify-content: center;
    }

    .article-content {
      font-size: var(--font-size-base);
    }

    .article-content :global(h2) {
      font-size: 1.5rem;
    }

    .article-content :global(h3) {
      font-size: 1.25rem;
    }
  }

  @media (max-width: 480px) {
    .article-featured-image img {
      max-height: 300px;
    }

    .article-title {
      font-size: 1.75rem;
    }
  }

  /* Loading animation */
  @keyframes shimmer {
    0% {
      background-position: -200px 0;
    }
    100% {
      background-position: calc(200px + 100%) 0;
    }
  }

  .article-detail.loading .article-content {
    background: linear-gradient(90deg, var(--bg-secondary) 25%, var(--bg-tertiary) 50%, var(--bg-secondary) 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
    border-radius: var(--radius-md);
    min-height: 200px;
  }
</style>
