<?php $this->layout('layouts::master', [
    'title' => $title ?? '405 - Method Not Allowed',
    'description' => 'The HTTP method used is not allowed for this resource.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-1">405</h1>
                <h2 class="mb-4">Method Not Allowed</h2>
                <p class="lead mb-4">
                    The HTTP method used is not allowed for this resource.
                </p>
                <?php if (isset($allowedMethods) && !empty($allowedMethods)): ?>
                    <p class="mb-4">
                        <strong>Allowed methods:</strong> <?= $this->e(implode(', ', $allowedMethods)) ?>
                    </p>
                <?php endif ?>
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
