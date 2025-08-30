<?php $this->layout('layouts::master', [
    'title' => $title ?? '401 - Unauthorized',
    'description' => 'Authentication is required to access this resource.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page min-h-screen bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Error Icon -->
        <div class="text-8xl mb-8">🔐</div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-red-600 mb-4">401</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Unauthorized</h2>
        
        <!-- Error Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-600 mb-4">
                You need to authenticate to access this resource.
            </p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-semibold text-red-800 mb-2">Authentication required:</h3>
                <ul class="text-left text-red-700 space-y-1">
                    <li>• Please log in to continue</li>
                    <li>• Check your credentials</li>
                    <li>• Your session may have expired</li>
                    <li>• Contact administrator if needed</li>
                </ul>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="space-x-4">
            <a href="/login" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login
            </a>
            <a href="/" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go Home
            </a>
        </div>
        
        <!-- Help Section -->
        <div class="mt-12 text-sm text-gray-500">
            <p>Need help? Contact support or check our documentation.</p>
            <p class="font-mono mt-2">Error Code: 401 | Time: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</div>
