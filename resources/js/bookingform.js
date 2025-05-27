document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (this.checkValidity()) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            submitBtn.classList.remove('btn-loading');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Booking Submitted!';
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-success');
            
            // Reset after 3 seconds
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-camera me-2"></i>Book My Session';
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-primary');
                this.reset();
            }, 3000);
        }, 2000);
    }
    
    this.classList.add('was-validated');
});

// Enhanced form interactions
const formControls = document.querySelectorAll('.form-control, .form-select');
formControls.forEach(control => {
    control.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
    });
    
    control.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});