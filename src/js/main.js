document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('.flash-message');
    
    flashMessages.forEach(function(message) {
        const closeButton = message.querySelector('.flash-close');
        
        function dismissMessage() {
            message.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            setTimeout(function() {
                message.remove();
            }, 300);
        }
        
        if (closeButton) {
            closeButton.addEventListener('click', dismissMessage);
        }
        
        setTimeout(dismissMessage, 5000);
    });
    
    const dateInput = document.getElementById('date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    if (dateInput && !dateInput.value) {
        const now = new Date();
        dateInput.value = now.toISOString().split('T')[0];
    }
    
    if (startTimeInput && !startTimeInput.value) {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        startTimeInput.value = `${hours}:${minutes}`;
    }
    
    if (endTimeInput && !endTimeInput.value) {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        endTimeInput.value = `${hours}:${minutes}`;
    }
    
    if (startTimeInput && endTimeInput) {
        startTimeInput.addEventListener('change', function() {
            if (endTimeInput.value && this.value >= endTimeInput.value) {
                const startTime = new Date('2000-01-01T' + this.value);
                startTime.setHours(startTime.getHours() + 1);
                const hours = String(startTime.getHours()).padStart(2, '0');
                const minutes = String(startTime.getMinutes()).padStart(2, '0');
                endTimeInput.value = `${hours}:${minutes}`;
            }
        });
    }
    
    const experienceForm = document.querySelector('form[action*="page=form"]');
    if (experienceForm) {
        const checkboxes = experienceForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const weatherCheckboxes = experienceForm.querySelectorAll('input[name="weather[]"]');
                const roadTypeCheckboxes = experienceForm.querySelectorAll('input[name="road_types[]"]');
                const trafficCheckboxes = experienceForm.querySelectorAll('input[name="traffic[]"]');
                
                const hasWeather = Array.from(weatherCheckboxes).some(cb => cb.checked);
                const hasRoadType = Array.from(roadTypeCheckboxes).some(cb => cb.checked);
                const hasTraffic = Array.from(trafficCheckboxes).some(cb => cb.checked);
                
                const submitButton = experienceForm.querySelector('button[type="submit"]');
                if (submitButton) {
                    if (!hasWeather || !hasRoadType || !hasTraffic) {
                        submitButton.disabled = true;
                        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
            });
        });
        
        experienceForm.addEventListener('submit', function(e) {
            const weatherCheckboxes = experienceForm.querySelectorAll('input[name="weather[]"]');
            const roadTypeCheckboxes = experienceForm.querySelectorAll('input[name="road_types[]"]');
            const trafficCheckboxes = experienceForm.querySelectorAll('input[name="traffic[]"]');
            
            if (weatherCheckboxes.length > 0 && roadTypeCheckboxes.length > 0 && trafficCheckboxes.length > 0) {
                const hasWeather = Array.from(weatherCheckboxes).some(cb => cb.checked);
                const hasRoadType = Array.from(roadTypeCheckboxes).some(cb => cb.checked);
                const hasTraffic = Array.from(trafficCheckboxes).some(cb => cb.checked);
                
                if (!hasWeather || !hasRoadType || !hasTraffic) {
                    e.preventDefault();
                    alert('Please select at least one option for Weather, Road Types, and Traffic Conditions.');
                    return false;
                }
            }
        });
    }
    
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
        
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            });
        });
    }
});
