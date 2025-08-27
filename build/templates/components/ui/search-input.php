<?php
/**
 * Search Input Component - converted from Lit boson-search-input component
 * HTMX-powered search with live results
 */

$action = $action ?? '/search';
$query = $query ?? '';
$placeholder = $placeholder ?? 'Search...';
$showResults = $showResults ?? true;
?>

<div class="search-input-component" 
     x-data="{ 
         query: '<?= htmlspecialchars($query) ?>',
         focused: false,
         hasResults: false 
     }">
    
    <!-- Search Form -->
    <form class="search-form" 
          hx-get="<?= $action ?>"
          hx-trigger="input changed delay:300ms from:input[name='q'], submit"
          hx-target="#search-results"
          hx-indicator="#search-loading"
          @submit.prevent>
        
        <div class="search-input-wrapper" :class="{ 'focused': focused }">
            <!-- Search Icon -->
            <svg class="search-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M7.333 12.667A5.333 5.333 0 1 0 7.333 2a5.333 5.333 0 0 0 0 10.667ZM14 14l-2.9-2.9" 
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <!-- Input Field -->
            <input type="text" 
                   name="q" 
                   class="search-input"
                   :value="query"
                   @input="query = $event.target.value"
                   @focus="focused = true"
                   @blur="focused = false"
                   placeholder="<?= htmlspecialchars($placeholder) ?>"
                   autocomplete="off"
                   aria-label="Search">

            <!-- Clear Button -->
            <button type="button" 
                    class="search-clear"
                    x-show="query.length > 0"
                    @click="query = ''; $refs.input.value = ''; $refs.input.focus()"
                    aria-label="Clear search">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M9 3L3 9M3 3l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>

            <!-- Loading Indicator -->
            <div id="search-loading" class="search-loading htmx-indicator">
                <svg class="spinner" width="16" height="16" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="2" 
                            fill="none" stroke-dasharray="37.7" stroke-dashoffset="37.7">
                        <animateTransform attributeName="transform" type="rotate" 
                                        values="0 8 8;360 8 8" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>
        </div>
    </form>

    <!-- Search Results -->
    <?php if ($showResults): ?>
    <div id="search-results" 
         class="search-results"
         x-show="query.length > 0"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">
        <!-- Results will be loaded here via HTMX -->
    </div>
    <?php endif; ?>
</div>



