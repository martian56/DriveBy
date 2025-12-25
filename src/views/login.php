<?php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=dashboard');
    exit;
}
?>

<div class="max-w-md mx-auto glass-card p-6 md:p-8 mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Login</h2>
    
    <form method="POST" action="index.php?page=login" class="space-y-6">
        <input type="hidden" name="action" value="login">
        
        <div>
            <label for="username" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Username or Email *</label>
            <input type="text" id="username" name="username" required 
                   class="input-futuristic w-full">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Password *</label>
            <input type="password" id="password" name="password" required 
                   class="input-futuristic w-full">
        </div>
        
        <button type="submit" class="btn-futuristic w-full">
            Login
        </button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-gray-400">Don't have an account? <a href="index.php?page=register" class="text-cyan-400 hover:text-cyan-300 hover:underline font-semibold font-rajdhani">Register here</a></p>
    </div>
</div>
