<?php
$formData = $controller->getFormData();
?>

<div class="max-w-2xl mx-auto glass-card p-6 md:p-8">
    <h2 class="text-3xl font-bold mb-6 font-orbitron bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Add Driving Experience</h2>
    
    <form method="POST" action="index.php?page=form" class="space-y-6">
        <input type="hidden" name="action" value="create">
        
        <div>
            <label for="date" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Date *</label>
            <input type="date" id="date" name="date" required 
                   value="<?php echo date('Y-m-d'); ?>"
                   class="input-futuristic w-full">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Start Time *</label>
                <input type="time" id="start_time" name="start_time" required 
                       class="input-futuristic w-full">
            </div>
            
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">End Time *</label>
                <input type="time" id="end_time" name="end_time" required 
                       class="input-futuristic w-full">
            </div>
        </div>
        
        <div>
            <label for="kilometers" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Kilometers *</label>
            <input type="number" id="kilometers" name="kilometers" required step="0.01" min="0"
                   inputmode="decimal"
                   class="input-futuristic w-full">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Weather Conditions *</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <?php foreach ($formData['weather'] as $weather): ?>
                    <label class="flex items-center space-x-2 p-3 glass-card border border-cyan-500/20 rounded-lg hover:border-cyan-500/50 cursor-pointer transition">
                        <input type="checkbox" name="weather[]" value="<?php echo $weather['id']; ?>" class="rounded accent-cyan-500">
                        <span class="text-sm text-gray-300"><?php echo htmlspecialchars($weather['name']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Road Types *</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <?php foreach ($formData['road_types'] as $roadType): ?>
                    <label class="flex items-center space-x-2 p-3 glass-card border border-purple-500/20 rounded-lg hover:border-purple-500/50 cursor-pointer transition">
                        <input type="checkbox" name="road_types[]" value="<?php echo $roadType['id']; ?>" class="rounded accent-purple-500">
                        <span class="text-sm text-gray-300"><?php echo htmlspecialchars($roadType['name']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Traffic Conditions *</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <?php foreach ($formData['traffic'] as $traffic): ?>
                    <label class="flex items-center space-x-2 p-3 glass-card border border-pink-500/20 rounded-lg hover:border-pink-500/50 cursor-pointer transition">
                        <input type="checkbox" name="traffic[]" value="<?php echo $traffic['id']; ?>" class="rounded accent-pink-500">
                        <span class="text-sm text-gray-300"><?php echo htmlspecialchars($traffic['name']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-300 mb-2 font-rajdhani">Notes</label>
            <textarea id="notes" name="notes" rows="4" 
                      class="input-futuristic w-full resize-none"></textarea>
        </div>
        
        <div class="flex gap-4">
            <button type="submit" class="btn-futuristic flex-1">
                Save Experience
            </button>
            <a href="index.php?page=dashboard" class="flex-1 bg-gray-700/50 text-gray-300 py-3 px-6 rounded-lg hover:bg-gray-700/70 transition font-semibold text-center border border-gray-600/50">
                Cancel
            </a>
        </div>
    </form>
</div>
