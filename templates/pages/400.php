<?php $this->layout('layouts::master', [
    'title' => $title ?? '400 - Bad Request',
    'description' => 'The request could not be understood by the server.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Error Icon -->
        <div class="text-8xl mb-8">⚠️</div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-orange-600 mb-4">400</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Bad Request</h2>
        
        <!-- Error Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-600 mb-4">
                The server could not understand your request due to invalid syntax or malformed data.
            </p>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <h3 class="font-semibold text-orange-800 mb-2">Common causes:</h3>
                <ul class="text-left text-orange-700 space-y-1">
                    <li>• Invalid form data or parameters</li>
                    <li>• Malformed JSON or XML in request body</li>
                    <li>• Missing required fields</li>
                    <li>• Invalid file upload</li>
                </ul>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="space-x-4">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go Home
            </a>
            <button onclick="history.back()" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Go Back
            </button>
        </div>
        
        <!-- Help Section -->
        <div class="mt-12 text-sm text-gray-500">
            <p>If you believe this is an error, please contact support with the following information:</p>
            <p class="font-mono mt-2">Error Code: 400 | Time: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</div>
