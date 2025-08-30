<?php
/**
 * Template partial for rendering a single article card.
 *
 * Variables expected:
 * - $article: ArticleResponse object
 * - $isSvelteTheme: bool
 */
?>

<?php if ($isSvelteTheme): ?>
    <div class="svelte-article-card" data-article-id="<?= htmlspecialchars($article->getId()) ?>">
        <h2><?= htmlspecialchars($article->getTitle()) ?></h2>
        <p><?= htmlspecialchars($article->getExcerpt()) ?></p>
        <!-- Add more Svelte-specific markup as needed -->
    </div>
<?php else: ?>
    <div class="article-card">
        <h2><?= htmlspecialchars($article->getTitle()) ?></h2>
        <p><?= htmlspecialchars($article->getExcerpt()) ?></p>
        <!-- Add more Tailwind or other markup as needed -->
    </div>
<?php endif; ?>
