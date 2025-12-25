<?php
function displayFlashMessages() {
    if (isset($_SESSION['success'])) {
        echo '<div class="flash-message glass-card bg-green-500/20 border border-green-400/50 text-green-300 px-4 py-3 rounded-lg mb-4 pulse-glow flex items-center justify-between" role="alert">';
        echo '<span class="block sm:inline font-rajdhani flex-1">' . htmlspecialchars($_SESSION['success']) . '</span>';
        echo '<button type="button" class="flash-close ml-4 text-green-300 hover:text-green-100 transition-colors focus:outline-none" aria-label="Close">';
        echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        echo '</svg>';
        echo '</button>';
        echo '</div>';
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        echo '<div class="flash-message glass-card bg-red-500/20 border border-red-400/50 text-red-300 px-4 py-3 rounded-lg mb-4 flex items-center justify-between" role="alert">';
        echo '<span class="block sm:inline font-rajdhani flex-1">' . htmlspecialchars($_SESSION['error']) . '</span>';
        echo '<button type="button" class="flash-close ml-4 text-red-300 hover:text-red-100 transition-colors focus:outline-none" aria-label="Close">';
        echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        echo '</svg>';
        echo '</button>';
        echo '</div>';
        unset($_SESSION['error']);
    }
}
