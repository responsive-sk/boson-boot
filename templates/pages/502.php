<?php $this->layout('layouts::master', [
    'title' => $title ?? '502 - Bad Gateway',
    'description' => 'The server received an invalid response from upstream server.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page min-h-screen bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Error Icon -->
        <div class="text-8xl mb-8">🔌</div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-purple-600 mb-4">502</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Bad Gateway</h2>
        
        <!-- Error Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-600 mb-4">
                The server received an invalid response from the upstream server.
            </p>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h3 class="font-semibold text-purple-800 mb-2">Gateway issue:</h3>
                <ul class="text-left text-purple-700 space-y-1">
                    <li>• Upstream server is down or overloaded</li>
                    <li>• Network connectivity issues</li>
                    <li>• Server configuration problems</li>
                    <li>• Temporary service disruption</li>
                </ul>
            </div>
        </div>
        
        <!-- Status Check -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Service Status</h3>
            <div class="flex items-center justify-center space-x-2">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-purple-600"></div>
                <span class="text-gray-600">Checking server status...</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">We're working to restore service</p>
        </div>
        
        <!-- Actions -->
        <div class="space-x-4">
            <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Try Again
            </button>
            <a href="/" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go Home
            </a>
        </div>
        
        <!-- Help Section -->
        <div class="mt-12 text-sm text-gray-500">
            <p>This is usually a temporary issue. Please try again in a few minutes.</p>
            <p class="font-mono mt-2">Error Code: 502 | Time: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</div>

<script>
// Auto-retry after 30 seconds
setTimeout(() => {
    const statusDiv = document.querySelector('.bg-white.rounded-lg.shadow-lg.p-6.mb-8');
    if (statusDiv) {
        statusDiv.innerHTML = `
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Auto-retry in progress...</h3>
            <div class="flex items-center justify-center space-x-2">
                <div class="animate-pulse rounded-full h-6 w-6 bg-blue-600"></div>
                <span class="text-gray-600">Attempting to reconnect...</span>
            </div>
        `;
        
        setTimeout(() => {
            location.reload();
        }, 3000);
    }
}, 30000);
</script>
