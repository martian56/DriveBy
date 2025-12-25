<?php
$userId = $_SESSION['user_id'];
$filters = [
    'date_from' => $_GET['date_from'] ?? '',
    'date_to' => $_GET['date_to'] ?? '',
    'weather_id' => $_GET['weather_id'] ?? ''
];

$summaryData = $controller->getSummaryData($userId, $filters);
$experiences = $summaryData['experiences'];
$totalKm = $summaryData['total_km'];

require_once __DIR__ . '/../models/Variable.php';
$variable = new Variable();
$allWeather = $variable->getAllWeather();
?>

<div class="glass-card p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Driving Experiences Summary</h2>
        <a href="index.php?page=export<?php echo !empty($filters['date_from']) ? '&date_from=' . urlencode($filters['date_from']) : ''; ?><?php echo !empty($filters['date_to']) ? '&date_to=' . urlencode($filters['date_to']) : ''; ?><?php echo !empty($filters['weather_id']) ? '&weather_id=' . urlencode($filters['weather_id']) : ''; ?>" 
           class="btn-futuristic inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
        </a>
    </div>
    
    <div class="mb-6 p-4 glass-card bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-cyan-500/30">
        <p class="text-lg font-semibold text-gray-300 font-rajdhani">
            Total Kilometers: <span class="stat-value text-2xl"><?php echo number_format($totalKm, 2); ?> km</span>
        </p>
    </div>
    
    <form method="GET" action="index.php" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="hidden" name="page" value="summary">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">From Date</label>
            <input type="date" name="date_from" value="<?php echo htmlspecialchars($filters['date_from']); ?>"
                   class="input-futuristic w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">To Date</label>
            <input type="date" name="date_to" value="<?php echo htmlspecialchars($filters['date_to']); ?>"
                   class="input-futuristic w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Weather</label>
            <select name="weather_id" class="input-futuristic w-full">
                <option value="">All</option>
                <?php foreach ($allWeather as $weather): ?>
                    <option value="<?php echo $weather['id']; ?>" <?php echo $filters['weather_id'] == $weather['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($weather['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-futuristic w-full">
                Filter
            </button>
        </div>
    </form>
    
    <?php if (empty($experiences)): ?>
        <p class="text-gray-400 text-center py-8">No experiences found. <a href="index.php?page=form" class="text-cyan-400 hover:text-cyan-300 hover:underline font-semibold">Add your first experience</a></p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table id="experiencesTable" class="table-futuristic min-w-full">
                <thead>
                    <tr>
                        <th class="cursor-pointer hover:bg-cyan-500/20" onclick="sortTable(0)">Date ↑↓</th>
                        <th class="cursor-pointer hover:bg-cyan-500/20" onclick="sortTable(1)">Start Time ↑↓</th>
                        <th class="cursor-pointer hover:bg-cyan-500/20" onclick="sortTable(2)">End Time ↑↓</th>
                        <th class="cursor-pointer hover:bg-cyan-500/20" onclick="sortTable(3)">Kilometers ↑↓</th>
                        <th>Weather</th>
                        <th>Road Types</th>
                        <th>Traffic</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach ($experiences as $exp): ?>
                    <tr>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['date']); ?></td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['start_time'] ?? ''); ?></td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['end_time'] ?? ''); ?></td>
                        <td class="text-cyan-400 font-semibold"><?php echo number_format($exp['kilometers'], 2); ?> km</td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['weather'] ?? 'N/A'); ?></td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['road_types'] ?? 'N/A'); ?></td>
                        <td class="text-gray-300"><?php echo htmlspecialchars($exp['traffic'] ?? 'N/A'); ?></td>
                        <td class="text-gray-300 max-w-xs truncate" title="<?php echo htmlspecialchars($exp['notes'] ?? ''); ?>">
                            <?php echo htmlspecialchars($exp['notes'] ?? ''); ?>
                        </td>
                        <td>
                            <form method="POST" action="index.php?page=summary" onsubmit="return confirm('Are you sure you want to delete this experience?');" class="inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $exp['id']; ?>">
                                <button type="submit" class="text-red-400 hover:text-red-300 font-semibold transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
let sortDirection = {};
function sortTable(columnIndex) {
    const table = document.getElementById('experiencesTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    sortDirection[columnIndex] = !sortDirection[columnIndex];
    const direction = sortDirection[columnIndex] ? 1 : -1;
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        if (columnIndex === 3) {
            const aNum = parseFloat(aText);
            const bNum = parseFloat(bText);
            return (aNum - bNum) * direction;
        }
        
        return aText.localeCompare(bText) * direction;
    });
    
    rows.forEach(row => tbody.appendChild(row));
}
</script>
