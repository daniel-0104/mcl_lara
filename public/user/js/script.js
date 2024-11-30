// href clicked active link start
document.addEventListener('DOMContentLoaded', () => {
    const currentHTMLPage = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => link.classList.remove('active'));

    navLinks.forEach(link => {
      const linkPath = new URL(link.href).pathname;
      if (currentHTMLPage === linkPath) {
        link.classList.add('active');
      }
    });
  });
// href clicked active link end


//................................. category click start ...........................
let detailsText = document.getElementsByClassName('text-content');

function detailsClick(event, elementId) {
    event.preventDefault();
    const clickText = event.target;

    for (let d of detailsText) {
        d.classList.remove('text-active');
    }
    clickText.classList.add('text-active');

    document.querySelectorAll('.plan-section').forEach(section => {
        section.style.display = 'none';
    });

    const selectedSection = document.getElementById(elementId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}
//........................................ category click end ................................


var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  grabCursor: true,
  speed: 1000,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

var swiper = new Swiper(".mySwiper2", {
  slidesPerView: 3,
  spaceBetween: 30,
  grabCursor: true,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    0: {
        slidesPerView: 1,
    },
    570: {
        slidesPerView: 2,
    },
    880: {
      slidesPerView: 3,
    },
    1300: {
        slidesPerView: 4,
    }
  }
});

