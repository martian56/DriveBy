<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive By - Futuristic Driving Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
            "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
        }
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen">
    <div id="threejs-container" class="fixed inset-0 -z-10 opacity-20 pointer-events-none"></div>
    <?php if (($page ?? 'landing') !== 'landing'): ?>
    <nav class="backdrop-blur-xl bg-black/20 border-b border-cyan-500/20 shadow-2xl sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="index.php?page=landing" class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent font-orbitron tracking-wider hover:opacity-80 transition">
                    <span class="text-cyan-400">DRIVE</span> <span class="text-purple-400">BY</span>
                </a>
                
                <button id="mobile-menu-button" class="md:hidden text-cyan-400 hover:text-cyan-300 transition p-2" aria-label="Toggle menu">
                    <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div id="mobile-menu" class="hidden md:flex md:items-center md:gap-4 absolute md:relative top-full left-0 right-0 md:top-auto md:left-auto md:right-auto bg-black/90 md:bg-transparent backdrop-blur-xl md:backdrop-blur-none border-b md:border-0 border-cyan-500/20 md:border-0 flex-col md:flex-row py-4 md:py-0">
                        <ul class="flex flex-col md:flex-row gap-2 w-full md:w-auto px-4 md:px-0">
                            <li><a href="index.php?page=dashboard" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? 'dashboard') === 'dashboard' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Dashboard</a></li>
                            <li><a href="index.php?page=form" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? '') === 'form' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Add Experience</a></li>
                            <li><a href="index.php?page=summary" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? '') === 'summary' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Summary</a></li>
                            <li><a href="index.php?page=statistics" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? '') === 'statistics' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Statistics</a></li>
                        </ul>
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-3 px-4 md:px-0 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-0 border-cyan-500/20 md:border-0 w-full md:w-auto">
                            <span class="text-sm text-gray-300 font-rajdhani"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
                            <a href="index.php?page=logout" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 px-4 py-2 rounded-lg text-sm transition-all shadow-lg shadow-red-500/50 font-rajdhani font-semibold w-full md:w-auto text-center">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div id="mobile-menu" class="hidden md:flex md:items-center gap-2 absolute md:relative top-full left-0 right-0 md:top-auto md:left-auto md:right-auto bg-black/90 md:bg-transparent backdrop-blur-xl md:backdrop-blur-none border-b md:border-0 border-cyan-500/20 md:border-0 flex-col md:flex-row py-4 md:py-0">
                        <ul class="flex flex-col md:flex-row gap-2 w-full md:w-auto px-4 md:px-0">
                            <li><a href="index.php?page=login" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? '') === 'login' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Login</a></li>
                            <li><a href="index.php?page=register" class="nav-link px-4 py-2 rounded-lg transition-all block <?php echo ($page ?? '') === 'register' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Register</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <main class="container mx-auto px-4 py-8 relative z-10 <?php echo (($page ?? 'landing') === 'landing') ? '' : ''; ?>">

