<?php $this->layout('layouts::master', [
    'title' => $title ?? '429 - Too Many Requests',
    'description' => 'Rate limit exceeded. Please slow down your requests.',
    'themeManager' => $themeManager ?? null
]) ?>

<div class="error-page min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Error Icon -->
        <div class="text-8xl mb-8">🚦</div>
        
        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-yellow-600 mb-4">429</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Too Many Requests</h2>
        
        <!-- Error Description -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <p class="text-lg text-gray-600 mb-4">
                You've exceeded the rate limit. Please slow down your requests.
            </p>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-800 mb-2">Rate limiting active:</h3>
                <ul class="text-left text-yellow-700 space-y-1">
                    <li>• Too many requests in short time</li>
                    <li>• Please wait before trying again</li>
                    <li>• Rate limits protect server performance</li>
                    <li>• Contact support if you need higher limits</li>
                </ul>
            </div>
        </div>
        
        <!-- Countdown Timer -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Please wait...</h3>
            <div class="text-3xl font-mono text-yellow-600" id="countdown">60</div>
            <p class="text-sm text-gray-600 mt-2">seconds until you can try again</p>
        </div>
        
        <!-- Actions -->
        <div class="space-x-4">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go Home
            </a>
            <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors" id="retryBtn" disabled>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span id="retryText">Retry (wait...)</span>
            </button>
        </div>
        
        <!-- Help Section -->
        <div class="mt-12 text-sm text-gray-500">
            <p>Rate limits help ensure fair usage for all users.</p>
            <p class="font-mono mt-2">Error Code: 429 | Time: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</div>

<script>
// Countdown timer
let countdown = 60;
const countdownEl = document.getElementById('countdown');
const retryBtn = document.getElementById('retryBtn');
const retryText = document.getElementById('retryText');

const timer = setInterval(() => {
    countdown--;
    countdownEl.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(timer);
        retryBtn.disabled = false;
        retryBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        retryText.textContent = 'Retry Now';
        countdownEl.textContent = '0';
        countdownEl.parentElement.innerHTML = '<div class="text-green-600 font-semibold">✅ You can try again now!</div>';
    }
}, 1000);

// Initially disable retry button
retryBtn.classList.add('opacity-50', 'cursor-not-allowed');
</script>
