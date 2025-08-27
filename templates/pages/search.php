<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
    'pageSubtitle' => $pageSubtitle,
    'breadcrumbs' => $breadcrumbs,
    'themeManager' => $themeManager ?? null
]) ?>

<?php $this->start('main') ?>

<div class="search-page">
    <div class="container">
        
        <!-- Search Form -->
        <div class="search-form-container">
            <form class="search-form" method="GET" action="/search">
                <div class="search-input-group">
                    <input 
                        type="text" 
                        name="q" 
                        value="<?= $this->escapeHtml($searchQuery ?? '') ?>" 
                        placeholder="Search documentation, articles, and examples..."
                        class="search-input"
                        autofocus
                    >
                    <button type="submit" class="search-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <div class="search-results">
            <?= $content ?? '' ?>
        </div>
        
    </div>
</div>

<style>
.search-page {
    padding: 2rem 0;
}

.search-form-container {
    margin-bottom: 3rem;
    text-align: center;
}

.search-form {
    max-width: 600px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    gap: 0.5rem;
    background: var(--bg-secondary, #f8f9fa);
    border: 1px solid var(--border, #e9ecef);
    border-radius: 8px;
    padding: 0.5rem;
}

.search-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    outline: none;
    color: var(--text-primary, #333);
}

.search-input::placeholder {
    color: var(--text-secondary, #666);
}

.search-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary, #007bff);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-button:hover {
    background: var(--primary-dark, #0056b3);
}

.search-results {
    min-height: 200px;
}

.search-result {
    padding: 1.5rem;
    border: 1px solid var(--border, #e9ecef);
    border-radius: 8px;
    margin-bottom: 1rem;
    background: var(--bg-primary, white);
}

.search-result h3 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary, #333);
}

.search-result h3 a {
    color: var(--primary, #007bff);
    text-decoration: none;
}

.search-result h3 a:hover {
    text-decoration: underline;
}

.search-result p {
    margin: 0.5rem 0;
    color: var(--text-secondary, #666);
    line-height: 1.5;
}

.search-result .meta {
    font-size: 0.875rem;
    color: var(--text-muted, #999);
    margin-top: 0.5rem;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary, #666);
}

.no-results h3 {
    margin-bottom: 1rem;
    color: var(--text-primary, #333);
}

@media (max-width: 768px) {
    .search-input-group {
        flex-direction: column;
    }
    
    .search-button {
        justify-content: center;
    }
}
</style>

<?php $this->stop() ?>
