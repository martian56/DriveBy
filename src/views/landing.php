<div class="min-h-screen flex flex-col relative overflow-hidden">
    <div class="flex-1 flex items-center justify-center py-20 px-4">
        <div class="relative z-10 text-center max-w-6xl mx-auto w-full">
            <div class="mb-12">
                <h1 class="text-6xl md:text-8xl font-orbitron font-black mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent" style="text-shadow: none; -webkit-font-smoothing: antialiased;">
                        DRIVE BY
                    </span>
                </h1>
                <div class="h-1 w-24 mx-auto bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 mb-8"></div>
            </div>
            
            <p class="text-3xl md:text-4xl text-gray-200 mb-6 font-rajdhani font-semibold">
                Your Driving Journey, Simplified
            </p>
            <p class="text-lg md:text-xl text-gray-400 mb-10 font-rajdhani max-w-2xl mx-auto leading-relaxed">
                Whether you're tracking supervised driving hours, analyzing your commute patterns, or building a comprehensive driving log, Drive By gives you the tools you need.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-20">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=dashboard" class="btn-futuristic text-lg px-10 py-4 font-rajdhani font-bold">
                        Go to Dashboard
                    </a>
                <?php else: ?>
                    <a href="index.php?page=register" class="btn-futuristic text-lg px-10 py-4 font-rajdhani font-bold">
                        Get Started Free
                    </a>
                    <a href="index.php?page=login" class="glass-card border border-cyan-500/30 text-cyan-400 px-10 py-4 rounded-lg hover:border-cyan-500/50 hover:bg-cyan-500/10 transition-all text-lg font-rajdhani font-semibold">
                        Sign In
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="relative z-10 px-4 pb-20">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="glass-card p-8 rounded-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 rounded-lg flex items-center justify-center mb-6 border border-cyan-500/30">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-cyan-400 mb-4 font-orbitron">Track Every Drive</h3>
                    <p class="text-gray-400 font-rajdhani leading-relaxed">
                        Log each driving session with detailed information. Record start and end times, distance traveled, weather conditions, road types, and traffic patterns. Everything you need in one place.
                    </p>
                </div>
                
                <div class="glass-card p-8 rounded-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-lg flex items-center justify-center mb-6 border border-purple-500/30">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-purple-400 mb-4 font-orbitron">Visual Analytics</h3>
                    <p class="text-gray-400 font-rajdhani leading-relaxed">
                        See your driving patterns come to life with interactive charts and graphs. Understand when you drive most, which conditions you encounter, and how your habits change over time.
                    </p>
                </div>
                
                <div class="glass-card p-8 rounded-xl">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500/20 to-pink-600/20 rounded-lg flex items-center justify-center mb-6 border border-pink-500/30">
                        <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-pink-400 mb-4 font-orbitron">Export & Share</h3>
                    <p class="text-gray-400 font-rajdhani leading-relaxed">
                        Download your complete driving history as CSV files. Perfect for record-keeping, insurance purposes, or further analysis in spreadsheet applications.
                    </p>
                </div>
            </div>
            
            <div class="glass-card p-10 rounded-xl mb-12">
                <h2 class="text-4xl font-bold mb-8 font-orbitron text-center">
                    <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Perfect For</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-cyan-400 mb-4 font-rajdhani">Student Drivers</h3>
                        <p class="text-gray-400 font-rajdhani leading-relaxed mb-4">
                            Track your supervised driving hours with precision. Record every session, note weather and road conditions, and build a comprehensive log that meets licensing requirements.
                        </p>
                        <ul class="space-y-2 text-gray-400 font-rajdhani">
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 mt-1">•</span>
                                <span>Track total hours and kilometers</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 mt-1">•</span>
                                <span>Document various driving conditions</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 mt-1">•</span>
                                <span>Export records for DMV submission</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-purple-400 mb-4 font-rajdhani">Professional Drivers</h3>
                        <p class="text-gray-400 font-rajdhani leading-relaxed mb-4">
                            Maintain detailed logs for work-related driving. Analyze patterns, optimize routes, and keep accurate records for reimbursement or tax purposes.
                        </p>
                        <ul class="space-y-2 text-gray-400 font-rajdhani">
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 mt-1">•</span>
                                <span>Comprehensive trip logging</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 mt-1">•</span>
                                <span>Pattern analysis and insights</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 mt-1">•</span>
                                <span>Professional reporting tools</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-10 rounded-xl">
                <h2 class="text-3xl font-bold mb-8 font-orbitron text-center">
                    <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">How It Works</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-cyan-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-cyan-500/30">
                            <span class="text-cyan-400 font-bold font-rajdhani text-xl">1</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani">Sign Up</h4>
                        <p class="text-sm text-gray-400 font-rajdhani">Create your free account in seconds</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-purple-500/30">
                            <span class="text-purple-400 font-bold font-rajdhani text-xl">2</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani">Log Drives</h4>
                        <p class="text-sm text-gray-400 font-rajdhani">Record each driving session with details</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-pink-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-pink-500/30">
                            <span class="text-pink-400 font-bold font-rajdhani text-xl">3</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani">Analyze</h4>
                        <p class="text-sm text-gray-400 font-rajdhani">View insights and statistics</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-500/30">
                            <span class="text-green-400 font-bold font-rajdhani text-xl">4</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani">Export</h4>
                        <p class="text-sm text-gray-400 font-rajdhani">Download your data anytime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
