<?php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=dashboard');
    exit;
}
?>

<div class="max-w-md mx-auto glass-card p-6 md:p-8 mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Register</h2>
    
    <form method="POST" action="index.php?page=register" class="space-y-6">
        <input type="hidden" name="action" value="register">
        
        <div>
            <label for="username" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Username *</label>
            <input type="text" id="username" name="username" required minlength="3"
                   class="input-futuristic w-full">
            <p class="text-xs text-gray-500 mt-1 font-rajdhani">Minimum 3 characters</p>
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Email *</label>
            <input type="email" id="email" name="email" required 
                   class="input-futuristic w-full">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Password *</label>
            <input type="password" id="password" name="password" required minlength="6"
                   class="input-futuristic w-full">
            <p class="text-xs text-gray-500 mt-1 font-rajdhani">Minimum 6 characters</p>
        </div>
        
        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Confirm Password *</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6"
                   class="input-futuristic w-full">
        </div>
        
        <button type="submit" class="btn-futuristic w-full">
            Register
        </button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-gray-400">Already have an account? <a href="index.php?page=login" class="text-cyan-400 hover:text-cyan-300 hover:underline font-semibold font-rajdhani">Login here</a></p>
    </div>
</div>
