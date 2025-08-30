<?php $this->layout('layouts::master', [
    'title' => $title ?? '404 - Page Not Found',
    'description' => 'The page you are looking for could not be found.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-1">404</h1>
                <h2 class="mb-4">Page Not Found</h2>
                <p class="lead mb-4">
                    <?= $this->e($message ?? 'The page you are looking for could not be found.') ?>
                </p>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary me-3">Go Home</a>
                    <a href="/search" class="btn btn-outline-secondary">Search</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.display-1 {
    font-size: 6rem;
    font-weight: 300;
    color: #6c757d;
}

.error-actions {
    margin-top: 2rem;
}
</style>
