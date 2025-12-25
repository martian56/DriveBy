<?php
$userId = $_SESSION['user_id'];
$dashboardData = $controller->getSummaryData($userId);
$totalKm = $dashboardData['total_km'];
$recent = array_slice($dashboardData['experiences'], 0, 5);
$stats = $controller->getStatistics($userId);
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stat-card glass-card float-animation">
        <h3 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani uppercase tracking-wider">Total Kilometers</h3>
        <p class="stat-value"><?php echo number_format($totalKm, 2); ?> <span class="text-xl text-cyan-400">km</span></p>
    </div>
    <div class="stat-card glass-card float-animation" style="animation-delay: 0.2s;">
        <h3 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani uppercase tracking-wider">Total Experiences</h3>
        <p class="stat-value"><?php echo count($dashboardData['experiences']); ?></p>
    </div>
    <div class="stat-card glass-card float-animation" style="animation-delay: 0.4s;">
        <h3 class="text-lg font-semibold text-gray-300 mb-2 font-rajdhani uppercase tracking-wider">Average per Trip</h3>
        <p class="stat-value">
            <?php 
            $count = count($dashboardData['experiences']);
            echo $count > 0 ? number_format($totalKm / $count, 2) : '0.00';
            ?> <span class="text-xl text-purple-400">km</span>
        </p>
    </div>
</div>

<div class="glass-card p-6 mb-8">
    <h2 class="text-3xl font-bold mb-6 font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Recent Experiences</h2>
    <?php if (empty($recent)): ?>
        <p class="text-gray-400 text-center py-8">No experiences recorded yet. <a href="index.php?page=form" class="text-cyan-400 hover:text-cyan-300 hover:underline font-semibold">Add your first experience</a></p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="table-futuristic min-w-full">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time Range</th>
                        <th>Kilometers</th>
                        <th>Weather</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($recent, 0, 5) as $exp): ?>
                    <tr>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['date']); ?></td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['start_time'] ?? ''); ?> - <?php echo htmlspecialchars($exp['end_time'] ?? ''); ?></td>
                        <td class="text-cyan-400 font-semibold"><?php echo number_format($exp['kilometers'], 2); ?> km</td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['weather'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="glass-card p-6">
        <h3 class="text-xl font-bold mb-4 font-orbitron text-cyan-400">Quick Actions</h3>
        <div class="space-y-3">
            <a href="index.php?page=form" class="btn-futuristic block w-full text-center">Add New Experience</a>
            <a href="index.php?page=summary" class="btn-futuristic block w-full text-center">View All Experiences</a>
            <a href="index.php?page=statistics" class="btn-futuristic block w-full text-center">View Statistics</a>
        </div>
    </div>
    <div class="glass-card p-6">
        <h3 class="text-xl font-bold mb-4 font-orbitron text-purple-400">Top Weather Conditions</h3>
        <ul class="space-y-2">
            <?php foreach (array_slice($stats['weather'], 0, 5) as $weather): ?>
                <li class="flex justify-between items-center p-2 bg-cyan-500/10 rounded-lg border border-cyan-500/20">
                    <span class="text-gray-300"><?php echo htmlspecialchars($weather['name']); ?></span>
                    <span class="bg-gradient-to-r from-cyan-500 to-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold font-rajdhani">
                        <?php echo $weather['count']; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
