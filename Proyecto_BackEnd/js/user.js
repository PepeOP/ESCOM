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

  document.addEventListener('DOMContentLoaded', function () {
    // Inicializa los modales al cargar la página
    var modals = M.Modal.init(document.querySelectorAll('.modal'), {});

    // Abre el primer modal al hacer clic en el ícono de Materialize en la lista
    var confirmacionElement = document.getElementById('confirmacionElement');
    confirmacionElement.addEventListener('click', function () {
      M.Modal.getInstance(document.getElementById('confirmacionModal')).open();
    });

    // Maneja la confirmación de asistencia
    var confirmacionForm = document.getElementById('confirmacionForm');
    confirmacionForm.addEventListener('submit', function (event) {
      event.preventDefault();

      // Lógica para manejar la confirmación de asistencia
      var confirmacionSi = document.getElementById('confirmacion_si').checked;

      console.log('Confirmación de asistencia:', confirmacionSi);

      // Cierra el popup después de procesar la confirmación
      M.Modal.getInstance(document.getElementById('confirmacionModal')).close();

      // Abre el segundo modal si la confirmación es "Sí"
      if (confirmacionSi) {
        M.Modal.getInstance(document.getElementById('invitacionModal')).open();
      }
    });

    // Maneja la confirmación de datos e invitación
    var invitacionForm = document.getElementById('invitacionForm');
    invitacionForm.addEventListener('submit', function (event) {
      event.preventDefault();

      // Lógica para manejar la confirmación de datos e invitación
      var llevarInvitado = document.querySelector('input[name="llevarInvitado"]:checked').value;
      var discapacidad = document.querySelector('input[name="discapacidad"]:checked').value;

      console.log('Llevará invitado:', llevarInvitado);
      console.log('Discapacidad:', discapacidad);

      // Puedes hacer más acciones aquí, como generar la invitación

      // Cierra el popup después de procesar la confirmación de datos e invitación
      M.Modal.getInstance(document.getElementById('invitacionModal')).close();
    });
  });