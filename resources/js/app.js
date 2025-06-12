import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Intersection Observer for fade-in animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// GSAP animations for hero section
gsap.from('.hero-content h1', {
    duration: 1.2,
    y: 50,
    opacity: 0,
    ease: 'power2.out',
    delay: 0.3
});

gsap.from('.hero-content p', {
    duration: 1,
    y: 30,
    opacity: 0,
    ease: 'power2.out',
    delay: 0.6
});

gsap.from('.hero-buttons', {
    duration: 1,
    y: 30,
    opacity: 0,
    ease: 'power2.out',
    delay: 0.9
});

// Service cards hover animation
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        gsap.to(card, {
            duration: 0.3,
            scale: 1.02,
            ease: 'power2.out'
        });
    });

    card.addEventListener('mouseleave', () => {
        gsap.to(card, {
            duration: 0.3,
            scale: 1,
            ease: 'power2.out'
        });
    });
});

// Mobile menu toggle (basic implementation)
document.querySelector('.mobile-menu').addEventListener('click', function() {
    // This would toggle mobile navigation
    // Implementation would depend on your mobile menu design
    console.log('Mobile menu clicked');
});

// Booking button actions
document.querySelectorAll('a[href="#booking"]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        // This would redirect to your Laravel booking system
        alert('Redirecting to booking system... (This would connect to your Laravel/Livewire booking interface)');
    });
});
