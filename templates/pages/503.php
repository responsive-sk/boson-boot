<?php $this->layout('layouts::master', [
    'title' => $title ?? '503 - Service Unavailable',
    'description' => 'The service is temporarily unavailable. Please try again later.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Error Icon -->
        <div class="text-8xl mb-8">🔧</div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-blue-600 mb-4">503</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Service Unavailable</h2>
        
        <!-- Error Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-600 mb-4">
                The service is temporarily unavailable due to maintenance or high load.
            </p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">Service status:</h3>
                <ul class="text-left text-blue-700 space-y-1">
                    <li>• Scheduled maintenance in progress</li>
                    <li>• Server temporarily overloaded</li>
                    <li>• Service will be restored shortly</li>
                    <li>• No data has been lost</li>
                </ul>
            </div>
        </div>
        
        <!-- Maintenance Info -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🛠️ Maintenance Mode</h3>
            <p class="text-gray-600 mb-4">
                We're performing scheduled maintenance to improve your experience.
            </p>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 font-medium">
                    ✅ Expected completion: Within 30 minutes
                </p>
                <p class="text-green-700 text-sm mt-1">
                    All services will be fully restored after maintenance
                </p>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="space-x-4">
            <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Check Again
            </button>
            <a href="mailto:support@example.com" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact Support
            </a>
        </div>
        
        <!-- Progress Indicator -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h4 class="font-semibold text-gray-800 mb-3">Maintenance Progress</h4>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 75%"></div>
            </div>
            <p class="text-sm text-gray-600 mt-2">75% complete</p>
        </div>
        
        <!-- Help Section -->
        <div class="mt-12 text-sm text-gray-500">
            <p>Thank you for your patience during this maintenance window.</p>
            <p class="font-mono mt-2">Error Code: 503 | Time: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</div>

<script>
// Auto-refresh every 2 minutes during maintenance
setInterval(() => {
    console.log('Checking if maintenance is complete...');
    // In a real application, you might check a status endpoint
    // For now, we'll just show a notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
    notification.textContent = 'Checking service status...';
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}, 120000); // Check every 2 minutes
</script>
