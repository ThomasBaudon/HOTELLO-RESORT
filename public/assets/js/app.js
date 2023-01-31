"use strict";

console.log("hello Thomas");


/* ------------------------------------------------------------------------------------------ */
/* BURGER MENU */
/* Toggle burger-menu */
/* ------------------------------------------------------------------------------------------ */
let burgerIcon = document.querySelector('.menu-trigger');
let mobileMenu = document.querySelector('.menu-mobile')

burgerIcon.addEventListener('click', ()=>{
    burgerIcon.classList.toggle('active');
    mobileMenu.classList.toggle('show');
})

/* ------------------------------------------------------------------------------------------ */
/* SIMPLE SLIDER */
/* ------------------------------------------------------------------------------------------ */
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block"; 
  setTimeout(showSlides, 7000);
}

/* ------------------------------------------------------------------------------------------ */
/* SWIPER HOME */
/* ------------------------------------------------------------------------------------------ */
const swiper = new Swiper('.swiper', {
  // Optional parameters
  loop: true,
  slidesPerView: 2,
  spaceBetween: 30,
  grabCursor: true,
  freeMode: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    640: {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 2,
      spaceBetween: 50,
    },
  },

 
});

/* ------------------------------------------------------------------------------------------ */
/* Image reveal */
/* ------------------------------------------------------------------------------------------ */

/* ---------- */
/* Horizontal */
/* ---------- */
const optionsHoriz = {
    root: null,
    rootmargin: "100px",
    threshold: 0.1
};

let revealCallbackHoriz = (entries, self) => {
    entries.forEach(entry => {
        let container = entry.target;
        let img = entry.target.querySelector("img");
        const easeInOut = "power4.out";
        const revealAnim = gsap.timeline({ease: easeInOut});

        if (entry.isIntersecting) {
            revealAnim.set(container, {
                visibility: "visible"
            });
            revealAnim.fromTo (
                container,
                {
                    clipPath : "polygon(0 0, 0 0, 0 100%, 0 100%)",
                    webkitClipPath : "polygon(0 0, 0 0, 0 100%, 0 100%)",
                },
                {
                    clipPath : "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
                    webkitClipPath : "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
                    duration: .5,
                    ease: easeInOut,
                },
            );
            revealAnim.from(img, 1, {
                scale: 1.4,
                ease: easeInOut,
                delay: -1
            });
            self.unobserve(entry.target);
        }
    });
};

let revealObserverHoriz = new IntersectionObserver(revealCallbackHoriz, optionsHoriz);
document.querySelectorAll(".reveal").forEach(reveal => {
    revealObserverHoriz.observe(reveal);
});


/* ---------- */
/* vertical */
/* ---------- */
const options = {
  root: null,
  rootmargin: "100px",
  threshold: 0.5
};

let revealCallback = (entries, self) => {
  entries.forEach(entry => {
      let container = entry.target;
      let img = entry.target.querySelector("img");
      const easeInOut = "power4.out";
      const revealAnim = gsap.timeline({ease: easeInOut});

      if (entry.isIntersecting) {
          revealAnim.set(container, {
              visibility: "visible"
          });
          revealAnim.fromTo (
              container,
              {
                  clipPath : "polygon(0% 0%, 0% 0%, 100% 0%, 100% 0%)",
                  webkitClipPath : "polygon(0% 0%, 0% 0%, 100% 0%, 100% 0%)",
              },
              {
                  clipPath : "polygon(0% 100%, 0% 0%, 100% 0%, 100% 100%)",
                  webkitClipPath : "polygon(0% 100%, 0% 0%, 100% 0%, 100% 100%)",
                  duration: 1,
                  ease: easeInOut,
              },
          );
          revealAnim.from(img, 1, {
              scale: 1.4,
              ease: easeInOut,
              delay: -1
          });
          self.unobserve(entry.target);
      }
  });
};

let revealObserver = new IntersectionObserver(revealCallback, options);
document.querySelectorAll(".revealVert").forEach(revealVert => {
  revealObserver.observe(revealVert);
});


/* ------------------------------------------------------------------------------------------ */
/* display or not - BTN Scroll top */
/* ------------------------------------------------------------------------------------------ */
let scrollPos = 0;
const scrollTop = document.getElementById('btn-top-page');
const header = document.querySelector('header');
const connexion = document.querySelector('.connexion');

function checkPosition() {
  let windowY = window.scrollY;
  if (windowY < 800) {
    // Scrolling UP
    scrollTop.classList.remove('is-visible');
    header.classList.remove('fixed');
    connexion.classList.remove('fixed');
  } else {
    // Scrolling DOWN
    scrollTop.classList.add('is-visible');
    header.classList.add('fixed');
    connexion.classList.add('fixed');
  }
  scrollPos = windowY;
}

window.addEventListener('scroll', checkPosition);


// loader page
// window.addEventListener('load', function() {
//     const loader = document.querySelector('.loader');
//     loader.className += ' hidden';
// }
// );