<script>
  import { onMount } from 'svelte'
  
  export let open = false
  
  let query = ''
  let results = []
  let loading = false
  let searchInput
  let searchTimeout
  
  async function performSearch() {
    if (query.length < 2) {
      results = []
      return
    }
    
    loading = true
    
    try {
      const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`)
      const data = await response.json()
      results = data.results || []
    } catch (error) {
      console.error('Search error:', error)
      results = []
    } finally {
      loading = false
    }
  }
  
  function handleInput() {
    clearTimeout(searchTimeout)
    searchTimeout = setTimeout(performSearch, 300)
  }
  
  function openModal() {
    open = true
    setTimeout(() => searchInput?.focus(), 100)
  }
  
  function closeModal() {
    open = false
    query = ''
    results = []
  }
  
  function handleKeydown(event) {
    if (event.key === 'Escape') {
      closeModal()
    }
  }
  
  function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    })
  }
  
  onMount(() => {
    // Global search shortcut
    function handleGlobalKeydown(event) {
      if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
        event.preventDefault()
        openModal()
      }
    }
    
    document.addEventListener('keydown', handleGlobalKeydown)
    
    return () => {
      document.removeEventListener('keydown', handleGlobalKeydown)
      clearTimeout(searchTimeout)
    }
  })
  
  // Export functions for external use
  export { openModal, closeModal }
</script>

{#if open}
  <div class="search-overlay svelte-fade" on:click={closeModal} on:keydown={handleKeydown}>
    <div class="search-modal" on:click|stopPropagation>
      <!-- Search Input -->
      <div class="search-header">
        <div class="search-input-container">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
          <input 
            bind:this={searchInput}
            bind:value={query}
            on:input={handleInput}
            type="search" 
            placeholder="Search articles, docs..." 
            class="search-input"
          />
          <button type="button" on:click={closeModal} class="search-close">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
      
      <!-- Search Results -->
      <div class="search-results">
        {#if loading}
          <div class="search-loading">
            <div class="spinner"></div>
            <span>Searching...</span>
          </div>
        {:else if query.length >= 2}
          {#if results.length > 0}
            <div class="results-list">
              {#each results as result}
                <a href={result.url} class="result-item" on:click={closeModal}>
                  <div class="result-content">
                    <div class="result-header">
                      <h3 class="result-title">{result.title}</h3>
                      <span class="result-category">{result.category}</span>
                    </div>
                    <p class="result-excerpt">{@html result.excerpt}</p>
                    <div class="result-meta">
                      <span class="result-date">{formatDate(result.published_at)}</span>
                    </div>
                  </div>
                  <div class="result-arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                  </div>
                </a>
              {/each}
            </div>
          {:else}
            <div class="no-results">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
              </svg>
              <h3>No results found</h3>
              <p>Try adjusting your search terms</p>
            </div>
          {/if}
        {:else if query.length > 0}
          <div class="search-hint">
            <p>Type at least 2 characters to search</p>
          </div>
        {:else}
          <div class="search-hint">
            <p>Start typing to search articles and documentation</p>
            <div class="search-shortcuts">
              <kbd>⌘K</kbd> or <kbd>Ctrl+K</kbd> to open search
            </div>
          </div>
        {/if}
      </div>
    </div>
  </div>
{/if}

<style>
  .search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 10vh 2rem 2rem;
  }
  
  .search-modal {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    width: 100%;
    max-width: 600px;
    max-height: 70vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  
  .search-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
  }
  
  .search-input-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--bg-secondary);
    transition: border-color 0.2s ease;
  }
  
  .search-input-container:focus-within {
    border-color: var(--primary);
    background: var(--bg-primary);
  }
  
  .search-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 1.125rem;
    background: transparent;
    color: var(--text-primary);
  }
  
  .search-input::placeholder {
    color: var(--text-muted);
  }
  
  .search-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: var(--radius);
    transition: color 0.2s ease;
  }
  
  .search-close:hover {
    color: var(--text-primary);
  }
  
  .search-results {
    flex: 1;
    overflow-y: auto;
    min-height: 200px;
  }
  
  .search-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 3rem;
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
    to { transform: rotate(360deg); }
  }
  
  .results-list {
    padding: 0.5rem;
  }
  
  .result-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
  }
  
  .result-item:hover {
    background: var(--bg-secondary);
    transform: translateY(-1px);
  }
  
  .result-content {
    flex: 1;
    min-width: 0;
  }
  
  .result-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
  }
  
  .result-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .result-category {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--primary);
    background: rgba(249, 57, 4, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius);
    white-space: nowrap;
  }
  
  .result-excerpt {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0 0 0.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .result-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  
  .result-date {
    font-size: 0.75rem;
    color: var(--text-muted);
  }
  
  .result-arrow {
    color: var(--text-muted);
    transition: all 0.2s ease;
  }
  
  .result-item:hover .result-arrow {
    color: var(--primary);
    transform: translateX(2px);
  }
  
  .no-results {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    text-align: center;
    color: var(--text-secondary);
  }
  
  .no-results svg {
    margin-bottom: 1rem;
    opacity: 0.5;
  }
  
  .no-results h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem;
  }
  
  .no-results p {
    margin: 0;
    font-size: 0.875rem;
  }
  
  .search-hint {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    text-align: center;
    color: var(--text-secondary);
  }
  
  .search-hint p {
    margin: 0 0 1rem;
    font-size: 0.875rem;
  }
  
  .search-shortcuts {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
  }
  
  kbd {
    background: var(--bg-secondary);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-family: var(--font-mono);
    font-size: 0.75rem;
    color: var(--text-primary);
  }
  
  @media (max-width: 768px) {
    .search-overlay {
      padding: 5vh 1rem 1rem;
    }
    
    .search-modal {
      max-height: 80vh;
    }
    
    .search-header {
      padding: 1rem;
    }
    
    .search-input-container {
      padding: 0.75rem 1rem;
    }
    
    .search-input {
      font-size: 1rem;
    }
    
    .result-item {
      padding: 0.75rem;
    }
    
    .result-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.5rem;
    }
    
    .result-title {
      white-space: normal;
    }
  }
</style>
