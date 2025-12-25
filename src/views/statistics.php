<?php
$userId = $_SESSION['user_id'];
$stats = $controller->getStatistics($userId);
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Driving Statistics</h2>
        <a href="index.php?page=export-stats" class="btn-futuristic inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-card p-6">
            <h3 class="text-xl font-bold mb-4 font-orbitron text-cyan-400">Weather Conditions Distribution</h3>
            <canvas id="weatherChart"></canvas>
        </div>
        
        <div class="glass-card p-6">
            <h3 class="text-xl font-bold mb-4 font-orbitron text-purple-400">Road Types Distribution</h3>
            <canvas id="roadTypesChart"></canvas>
        </div>
        
        <div class="glass-card p-6">
            <h3 class="text-xl font-bold mb-4 font-orbitron text-pink-400">Traffic Conditions Distribution</h3>
            <canvas id="trafficChart"></canvas>
        </div>
        
        <div class="glass-card p-6">
            <h3 class="text-xl font-bold mb-4 font-orbitron text-green-400">Monthly Kilometers</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    
    <div class="glass-card p-6">
        <h3 class="text-xl font-bold mb-4 font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Detailed Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-semibold text-gray-300 mb-3 font-rajdhani uppercase tracking-wider">Weather Conditions</h4>
                <ul class="space-y-2">
                    <?php foreach ($stats['weather'] as $weather): ?>
                        <li class="flex justify-between items-center p-2 glass-card bg-cyan-500/10 border border-cyan-500/20 rounded-lg">
                            <span class="text-gray-300"><?php echo htmlspecialchars($weather['name']); ?></span>
                            <span class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold font-rajdhani">
                                <?php echo $weather['count']; ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-300 mb-3 font-rajdhani uppercase tracking-wider">Road Types</h4>
                <ul class="space-y-2">
                    <?php foreach ($stats['road_types'] as $roadType): ?>
                        <li class="flex justify-between items-center p-2 glass-card bg-purple-500/10 border border-purple-500/20 rounded-lg">
                            <span class="text-gray-300"><?php echo htmlspecialchars($roadType['name']); ?></span>
                            <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-semibold font-rajdhani">
                                <?php echo $roadType['count']; ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-300 mb-3 font-rajdhani uppercase tracking-wider">Traffic Conditions</h4>
                <ul class="space-y-2">
                    <?php foreach ($stats['traffic'] as $traffic): ?>
                        <li class="flex justify-between items-center p-2 glass-card bg-pink-500/10 border border-pink-500/20 rounded-lg">
                            <span class="text-gray-300"><?php echo htmlspecialchars($traffic['name']); ?></span>
                            <span class="bg-gradient-to-r from-pink-500 to-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold font-rajdhani">
                                <?php echo $traffic['count']; ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
const weatherData = <?php echo json_encode($stats['weather']); ?>;
const roadTypesData = <?php echo json_encode($stats['road_types']); ?>;
const trafficData = <?php echo json_encode($stats['traffic']); ?>;
const monthlyData = <?php echo json_encode($stats['monthly_km']); ?>;

const futuristicColors = ['#00f0ff', '#b026ff', '#ff006e', '#00ff88', '#ffaa00', '#ff0080', '#00d4ff'];

Chart.defaults.color = '#e0e0e0';
Chart.defaults.borderColor = 'rgba(0, 240, 255, 0.2)';

new Chart(document.getElementById('weatherChart'), {
    type: 'doughnut',
    data: {
        labels: weatherData.map(w => w.name),
        datasets: [{
            data: weatherData.map(w => w.count),
            backgroundColor: futuristicColors.slice(0, weatherData.length),
            borderColor: '#0a0a0f',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                labels: {
                    color: '#e0e0e0',
                    font: {
                        family: 'Rajdhani'
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('roadTypesChart'), {
    type: 'bar',
    data: {
        labels: roadTypesData.map(r => r.name),
        datasets: [{
            label: 'Count',
            data: roadTypesData.map(r => r.count),
            backgroundColor: 'rgba(0, 240, 255, 0.6)',
            borderColor: '#00f0ff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#e0e0e0'
                },
                grid: {
                    color: 'rgba(0, 240, 255, 0.1)'
                }
            },
            x: {
                ticks: {
                    color: '#e0e0e0'
                },
                grid: {
                    color: 'rgba(0, 240, 255, 0.1)'
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: '#e0e0e0',
                    font: {
                        family: 'Rajdhani'
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('trafficChart'), {
    type: 'pie',
    data: {
        labels: trafficData.map(t => t.name),
        datasets: [{
            data: trafficData.map(t => t.count),
            backgroundColor: futuristicColors.slice(0, trafficData.length),
            borderColor: '#0a0a0f',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                labels: {
                    color: '#e0e0e0',
                    font: {
                        family: 'Rajdhani'
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: monthlyData.map(m => m.month),
        datasets: [{
            label: 'Kilometers',
            data: monthlyData.map(m => parseFloat(m.km)),
            borderColor: '#00ff88',
            backgroundColor: 'rgba(0, 255, 136, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#e0e0e0'
                },
                grid: {
                    color: 'rgba(0, 255, 136, 0.1)'
                }
            },
            x: {
                ticks: {
                    color: '#e0e0e0'
                },
                grid: {
                    color: 'rgba(0, 255, 136, 0.1)'
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: '#e0e0e0',
                    font: {
                        family: 'Rajdhani'
                    }
                }
            }
        }
    }
});
</script>
