<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
    'pageSubtitle' => $pageSubtitle,
    'breadcrumbs' => $breadcrumbs
]) ?>

<?php $this->start('main') ?>

<div class="about-page">
    <div class="container">
        <?= $aboutContent ?>
    </div>
</div>

<style>
.about-page {
    padding: 2rem 0 4rem;
}

.about-page .container {
    max-width: 800px;
}

.about-page h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 2.5rem 0 1rem;
    color: var(--text-primary);
}

.about-page h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 2rem 0 1rem;
    color: var(--text-primary);
}

.about-page p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

.about-page ul {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.about-page li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
    color: var(--text-secondary);
}

.about-page blockquote {
    border-left: 4px solid var(--primary);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: var(--text-secondary);
}

.about-page .highlight {
    background: var(--surface-secondary);
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.about-page .highlight h3 {
    margin-top: 0;
}
</style>

<?php $this->stop() ?>
