// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    const navitem = document.querySelector('.nav-links');
    const logo = document.querySelector('#navbar .logo');
    const logo_icon = document.getElementById('logo-icon');
    const user_btn = document.getElementById('userDropdown');
    const hambur = document.getElementById('hambur');
    const login = document.getElementById('login');
    const register = document.getElementById('register');

    console.log(hambur);
    // console.log(collap);
    if (window.scrollY > 100) {
        hambur.classList.add('text-dark');
        hambur.classList.remove('text-white');
        navbar.classList.add('scrolled');
        navitem.classList.add('scrolled');
        logo.classList.add('scrolled');
        // logo_icon.src = 'images/icon/icon_black.png'; // Change logo link on scroll
        if(user_btn){
            user_btn.classList.remove('text-light'); user_btn.classList.add('text-dark'); 
            user_btn.classList.remove('border-light'); user_btn.classList.add('border-dark'); 
        }
        if(login) {
            login.classList.remove('btn-outline-light'); login.classList.add('btn-outline-dark'); 
            register.classList.remove('btn-light'); register.classList.add('btn-dark'); 
        }
        
    } else {
        hambur.classList.remove('text-dark');
        hambur.classList.add('text-white');
        navbar.classList.remove('scrolled');
        navitem.classList.remove('scrolled');
        logo.classList.remove('scrolled');
        // logo_icon.src = 'images/icon/icon_white.png'; // Change logo link on scroll
        if(user_btn){
            user_btn.classList.remove('text-dark'); user_btn.classList.add('text-light'); 
            user_btn.classList.remove('border-dark'); user_btn.classList.add('border-light'); 
        }
        if(login) {
            login.classList.add('btn-outline-light'); login.classList.remove('btn-outline-dark'); 
            register.classList.add('btn-light'); register.classList.remove('btn-dark'); 
        }
    }
});

// Intersection Observer for fade-in animations
const observerOptions = {
    threshold: 0.1, // If element is 10% visible then fire the function
    rootMargin: '0px 0px -50px 0px' // viewport detection bottom is shrinked -50px 
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