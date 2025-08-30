<?php
/**
 * Template partial for rendering the Load More Articles button.
 *
 * Variables expected:
 * - $nextPage: int
 * - $categoryId: int|null
 */
$categoryQueryParam = $categoryId !== null ? '&categoryId=' . intval($categoryId) : '';
?>

<div class="load-more-container" id="load-more-container">
    <button
        class="btn btn-outline load-more-btn"
        hx-get="/api/articles/load-more?page=<?= $nextPage . $categoryQueryParam ?>"
        hx-target="#articles-container"
        hx-swap="beforeend"
        hx-indicator="#loading-indicator"
    >
        Load More Articles
    </button>
</div>
