let menu = document.querySelector('.bx-menu');
let navbar = document.querySelector('.navbar');
menu.addEventListener('click', function(){
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('nav-toggle');
})
window.addEventListener('scroll', ()=>{
    menu.classList.remove('bx-x');
    navbar.classList.remove('nav-toggle');
})
const header = document.querySelector('header');
window.onscroll = function(){
    if(document.documentElement.scrollTop > 5){
        header.style.height = '100px';
        header.style.backgroundColor = '#fff'
    }else{
        header.style.height = '100px';
        header.style.backgroundColor = '#fff'
    }
}
//home slider
const imgBox = document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slideBox');
var i = 0;
function nextSlide(){
    slides[i].classList.remove('active');
    i = (i + 1) % slides.length;
    slides[i].classList.add('active');
}
function prevSlide(){
    slides[i].classList.remove('active');
    i = (i - 1 + slides.length) % slides.length;
    slides[i].classList.add('active');
}
setInterval(nextSlide, 5000);
// Animation
/* animation của icon */
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".icon");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".review");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
/* animation của gioithieu */
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".gioithieu");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".review");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
/* animation của blog */
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".blog");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
document.addEventListener("DOMContentLoaded", function() {
    const iconEl = document.querySelector(".review");
    const checkScroll = () => {
        let scrollPos = window.scrollY + window.innerHeight;
        let elemPos = iconEl.offsetTop + iconEl.offsetHeight / 2;
        if (scrollPos > elemPos) {
            iconEl.classList.add("active");
        }
    };
    window.addEventListener("scroll", checkScroll);
});
/* animation của sản phẩm */
document.addEventListener("DOMContentLoaded", function() {
    const rows = document.querySelectorAll(".sanpham .row");
    const checkScroll = () => {
        rows.forEach(row => {
            let scrollPos = window.scrollY + window.innerHeight;
            let rowPos = row.offsetTop + row.offsetHeight / 2;
            if (scrollPos > rowPos) {
                const images = row.querySelectorAll('.image');
                images.forEach(image => image.classList.add("active"));
                const contents = row.querySelectorAll('.content');
                contents.forEach(content => content.classList.add("active"));
            }
        });
    };
    window.addEventListener("scroll", checkScroll);
});
//time
document.addEventListener('DOMContentLoaded', function() {
    var endTime = new Date("2023-08-30T18:41:00").getTime();
    var interval = setInterval(function() {
        var now = new Date().getTime();
        var timeLeft = endTime - now;
        var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        document.querySelector('.countdown .days').textContent = days;
        document.querySelector('.countdown .hours').textContent = hours;
        document.querySelector('.countdown .minutes').textContent = minutes;
        document.querySelector('.countdown .seconds').textContent = seconds;
        if (timeLeft < 0) {
            clearInterval(interval);
            document.querySelector('.countdown').textContent = "SALE END";
        }
    }, 1000);
});
document.querySelectorAll('.thumbnails img').forEach(thumbnail => {
    thumbnail.addEventListener('click', function() {
        const mainImage = document.querySelector('.main-image img');
        mainImage.src = this.src;
        mainImage.style.transform = 'scale(1.1)';
        setTimeout(() => {
            mainImage.style.transform = 'scale(1)';
        }, 300);
    });
});




