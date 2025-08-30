<?php $this->layout('layouts::master', [
    'title' => $title ?? 'Debug Error',
    'description' => 'Application error occurred during development.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="debug-error">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="error-header bg-danger text-white p-4 mb-4">
                    <h1 class="h3 mb-2">🐛 Debug Error</h1>
                    <p class="mb-0 font-monospace"><?= $this->e(get_class($exception)) ?></p>
                </div>

                <div class="error-details">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Error Message</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-danger font-monospace">
                                        <?= $this->e($message) ?>
                                    </p>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Location</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1">
                                        <strong>File:</strong> 
                                        <code><?= $this->e($file) ?></code>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Line:</strong> 
                                        <span class="badge bg-secondary"><?= $line ?></span>
                                    </p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Stack Trace</h5>
                                </div>
                                <div class="card-body">
                                    <pre class="bg-light p-3 small" style="max-height: 400px; overflow-y: auto;"><code><?= $this->e($trace) ?></code></pre>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Request Info</h5>
                                </div>
                                <div class="card-body small">
                                    <p><strong>Method:</strong> <?= $this->e($_SERVER['REQUEST_METHOD'] ?? 'Unknown') ?></p>
                                    <p><strong>URI:</strong> <?= $this->e($_SERVER['REQUEST_URI'] ?? 'Unknown') ?></p>
                                    <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
                                    <p><strong>IP:</strong> <?= $this->e($_SERVER['REMOTE_ADDR'] ?? 'Unknown') ?></p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <a href="/" class="btn btn-primary btn-sm d-block mb-2">Go Home</a>
                                    <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm d-block mb-2">Go Back</a>
                                    <button onclick="location.reload()" class="btn btn-outline-info btn-sm d-block">Reload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.debug-error {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.debug-error pre {
    font-size: 0.85rem;
    line-height: 1.4;
}

.debug-error .font-monospace {
    font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', Consolas, 'Courier New', monospace;
}

.debug-error .card {
    border: 1px solid #dee2e6;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.debug-error .error-header {
    border-radius: 0.375rem;
}
</style>
