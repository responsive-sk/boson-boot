<?php $this->layout('layouts::master', [
    'title' => $title ?? 'Error',
    'description' => 'An error occurred while processing your request.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-1"><?= $this->e($status ?? '500') ?></h1>
                <h2 class="mb-4">
                    <?php if (($status ?? 500) === 500): ?>
                        Internal Server Error
                    <?php else: ?>
                        Error <?= $this->e($status ?? '500') ?>
                    <?php endif ?>
                </h2>
                <p class="lead mb-4">
                    <?= $this->e($message ?? 'An error occurred while processing your request.') ?>
                </p>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary me-3">Go Home</a>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
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
