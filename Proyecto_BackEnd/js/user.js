document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems, {
      direction: 'left'
    });

    // Agrega el evento de clic para volver al inicio de la página
    document.getElementById('scrollToTop').addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Agrega el evento de desplazamiento para cambiar el ícono dinámicamente
    window.addEventListener('scroll', function() {
      var scrollPosition = window.scrollY;
      var halfWindowHeight = window.innerHeight / 2;

      var button = document.getElementById('scrollToTop');
      var menuIcon = button.querySelector('.menu-icon');
      var arrowIcon = button.querySelector('.arrow-icon');

      if (scrollPosition > halfWindowHeight) {
        // Si el scroll supera la mitad de la pantalla, muestra el ícono de flecha
        button.classList.add('show-arrow');
      } else {
        // Si el scroll está en la mitad de la pantalla o menos, muestra el ícono de menú
        button.classList.remove('show-arrow');
      }
    });
  });