//................................ sidebar toggle start .......................
const sidebarToggle = document.querySelector("#sidebar-toggle");
const sidebar = document.querySelector("#sidebar");
const main = document.querySelector('.main');

function toggleSidebar() {
    if (window.innerWidth <= 1160) {
        if (sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === '') {
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.opacity = 0;
            main.style.width = '100%';
        } else {
            sidebar.style.transform = 'translateX(0px)';
            sidebar.style.opacity = 1;
            main.style.width = '77%';
        }
    } else {
        sidebar.classList.toggle("collapsed");
        main.style.width = sidebar.classList.contains("collapsed") ? '100%' : '77%';
    }
}

sidebarToggle.addEventListener("click", toggleSidebar);

window.addEventListener("load", function() {
    if (window.innerWidth <= 1160) {
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.opacity = 0;
        main.style.width = '100%';
    } else {
        sidebar.style.transform = 'translateX(0px)';
        sidebar.style.opacity = 1;
        main.style.width = '77%';
    }
});

window.addEventListener("resize", function() {
    if (window.innerWidth <= 1160) {
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.opacity = 0;
        main.style.width = '100%';
    } else {
        sidebar.style.transform = sidebar.classList.contains("collapsed") ? 'translateX(-100%)' : 'translateX(0px)';
        sidebar.style.opacity = sidebar.classList.contains("collapsed") ? 0 : 1;
        main.style.width = sidebar.classList.contains("collapsed") ? '100%' : '77%';
    }
});
//............................... sidebar toggle end .......................


//............................... sidebar click active start .......................
document.addEventListener('DOMContentLoaded', function () {
  const currentHTMLPage = window.location.href;
  const mainLinks = document.querySelectorAll('.sidebar-link-name');
  const subLinks = document.querySelectorAll('.sidebar-link');
  const sidebar = document.querySelector('#sidebar');

  function activateMainLink(mainLink){
    mainLink.classList.add('active');
    const parentUl = mainLink.getAttribute('data-bs-target');
    const collapseElement = document.querySelector(parentUl);
    if (collapseElement){
      collapseElement.classList.add('show');
    }
  }

  subLinks.forEach(subLink => {
    if (currentHTMLPage.includes(subLink.getAttribute('href'))) {
      subLink.classList.add('active');
      const mainLink = subLink.closest('ul').previousElementSibling;
      if (mainLink && mainLink.classList.contains('sidebar-link-name')){
        activateMainLink(mainLink);
      }
    }
  });

  mainLinks.forEach(link => link.classList.remove('active'));

  mainLinks.forEach(link => {
    if (currentHTMLPage.includes(link.getAttribute('href'))) {
      link.classList.add('active');
    }
  });

  const savedScrollPosition = sessionStorage.getItem('sidebar-scroll-position');
  if (savedScrollPosition !== null) {
    sidebar.scrollTop = parseInt(savedScrollPosition, 10);
  }

  document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', function () {
      sessionStorage.setItem('sidebar-scroll-position', sidebar.scrollTop);
    });
  });
});

//............................... sidebar click active start .......................


// input image view
var loadFile = function (event) {
  var image = document.getElementById("output");
  image.src = URL.createObjectURL(event.target.files[0]);
};
