<?php $this->layout('layouts::app', [
    'title' => $title,
    'description' => $description,
    'currentRoute' => $currentRoute,
    'pageTitle' => $pageTitle,
    'pageSubtitle' => $pageSubtitle,
    'breadcrumbs' => $breadcrumbs
]) ?>

<?php $this->start('main') ?>

<div class="contact-page">
    <div class="container">
        <?= $contactContent ?>
    </div>
</div>

<style>
.contact-page {
    padding: 2rem 0 4rem;
}

.contact-page .container {
    max-width: 800px;
}

.contact-page h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 2.5rem 0 1rem;
    color: var(--text-primary);
}

.contact-page h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 2rem 0 1rem;
    color: var(--text-primary);
}

.contact-page p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

.contact-page .contact-info {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 2rem;
    margin: 2rem 0;
}

.contact-page .contact-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.contact-page .contact-method:last-child {
    margin-bottom: 0;
}

.contact-page .contact-icon {
    width: 24px;
    height: 24px;
    color: var(--primary);
}

.contact-page .contact-details h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem;
    color: var(--text-primary);
}

.contact-page .contact-details p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.contact-page .contact-details a {
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.contact-page .contact-details a:hover {
    color: var(--primary-dark);
}
</style>

<?php $this->stop() ?>
