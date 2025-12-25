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
            <div class="flex flex-wrap items-center justify-between">
                <a href="index.php?page=landing" class="text-3xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent font-orbitron tracking-wider hover:opacity-80 transition">
                    <span class="text-cyan-400">DRIVE</span> <span class="text-purple-400">BY</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex flex-wrap items-center gap-4 mt-2 md:mt-0">
                        <ul class="flex flex-wrap gap-2">
                            <li><a href="index.php?page=dashboard" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? 'dashboard') === 'dashboard' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Dashboard</a></li>
                            <li><a href="index.php?page=form" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? '') === 'form' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Add Experience</a></li>
                            <li><a href="index.php?page=summary" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? '') === 'summary' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Summary</a></li>
                            <li><a href="index.php?page=statistics" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? '') === 'statistics' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Statistics</a></li>
                        </ul>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-300 font-rajdhani"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
                            <a href="index.php?page=logout" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 px-4 py-2 rounded-lg text-sm transition-all shadow-lg shadow-red-500/50 font-rajdhani font-semibold">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <ul class="flex flex-wrap gap-2 mt-2 md:mt-0">
                        <li><a href="index.php?page=login" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? '') === 'login' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Login</a></li>
                        <li><a href="index.php?page=register" class="nav-link px-4 py-2 rounded-lg transition-all <?php echo ($page ?? '') === 'register' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/50' : 'text-gray-300 hover:text-cyan-400 hover:bg-cyan-500/10'; ?>">Register</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <main class="container mx-auto px-4 py-8 relative z-10 <?php echo (($page ?? 'landing') === 'landing') ? '' : ''; ?>">

