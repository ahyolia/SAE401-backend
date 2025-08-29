// === MENU BURGER ===
const burgerBtn = document.getElementById('burger-btn');
const nav = document.getElementById('main-nav');

burgerBtn.addEventListener('click', () => {
  nav.classList.toggle('active');
});

// === CAROUSEL ACTUALITÉS ===
const newsBox = document.getElementById('news-box');
const newsItems = newsBox.querySelectorAll('.news');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let currentNewsIndex = 0;

function showNews(index) {
  newsBox.style.transform = `translateX(-${index * 100}%)`;
}

nextBtn.addEventListener('click', () => {
  currentNewsIndex = (currentNewsIndex + 1) % newsItems.length;
  showNews(currentNewsIndex);
});

prevBtn.addEventListener('click', () => {
  currentNewsIndex = (currentNewsIndex - 1 + newsItems.length) % newsItems.length;
  showNews(currentNewsIndex);
});

newsBox.style.display = 'flex';
newsBox.style.transition = 'transform 0.4s ease';
newsItems.forEach(item => {
  item.style.flex = '0 0 100%';
});

// === CAROUSEL INTRODUCTION ===
// === CAROUSEL INTRODUCTION ===
const slideImages = document.querySelectorAll('.slides img');
const dotsContainer = document.getElementById('dots');
let current = 0;

if (slideImages.length > 0 && dotsContainer) {
  // Crée les points
  slideImages.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
  });

  function updateDisplay() {
    slideImages.forEach((img, i) => {
      img.classList.toggle('active', i === current);
    });
    const dots = dotsContainer.querySelectorAll('span');
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === current);
    });
  }

  function goToSlide(index) {
    current = index;
    updateDisplay();
  }

  function nextSlide() {
    current = (current + 1) % slideImages.length;
    updateDisplay();
  }

  updateDisplay();
  setInterval(nextSlide, 5000); // auto défilement
}

// Défilement automatique du carrousel partenaires
document.addEventListener('DOMContentLoaded', function() {
  const track = document.querySelector('.carousel-track');
  const items = document.querySelectorAll('.carousel-item');
  if (!track || items.length <= 1) return;

  let current = 0;
  const visibleCount = Math.floor(track.offsetWidth / items[0].offsetWidth) || 1;
  const total = items.length;
  const scrollStep = items[0].offsetWidth + 30; // 30px = gap

  function scrollToCurrent() {
    track.scrollTo({
      left: current * scrollStep,
      behavior: 'smooth'
    });
  }

  setInterval(() => {
    current = (current + 1) % total;
    scrollToCurrent();
  }, 2500); // Change toutes les 2.5 secondes
});
