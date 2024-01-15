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

document.addEventListener('DOMContentLoaded', async function () {

    // Comprueba si el token existe en localStorage o sessionStorage
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');

    if (!token) {
        // Si no hay token, redirige al home
        window.location.href = "/proyectoPEPE/";
    } else {
        // Validar token
        const response = await fetch('http://localhost/proyectoPEPE/api.php', {
            method: 'POST',
            body: JSON.stringify({
                "action": "validateToken",
                "token": token
            })
        });
        const result = await response.json();


        if( result.data ) {
            if ( !result.data.is_valid ) {
                localStorage.removeItem('token');
                sessionStorage.removeItem('token');
                window.location.href = "/proyectoPEPE/";
                return;
            }
        }
    }


    // Load data

    const response = await fetch('http://localhost/proyectoPEPE/api.php', {
        method: 'POST',
        body: JSON.stringify({
            "action": "getUserData",
            "token": token
        })
    });
    const result = await response.json();

    function llenarLista(datos, selectorTitulo, selectorLista) {
        var titulo = document.querySelector(selectorTitulo);
        var lista = document.querySelector(selectorLista);

        // Verificar si hay datos para mostrar
        if (datos.length > 0) {
            lista.innerHTML = ''; // Limpiar la lista existente

            datos.forEach(function(item) {
                var li = document.createElement('li');
                li.className = 'collection-item';
                li.textContent = `${item.nombre} - ${item.dependencia} - ${item.distincion}`;
                lista.appendChild(li);
            });

            titulo.style.display = ''; // Mostrar el título
            lista.style.display = ''; // Mostrar la lista
        } else {
            titulo.style.display = 'none'; // Ocultar el título
            lista.style.display = 'none'; // Ocultar la lista
        }
    }

    if( result.data ) {
        llenarLista(result.data.administrativos, '#tituloAdministrativos', '#listaAdministrativos');
        llenarLista(result.data.docentes, '#tituloDocentes', '#listaDocentes');
    } else {
        console.log("ERROR AL OBTENER LOS DATOS DE LA PERSONA");
        console.log(result);
    }



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


document.getElementById('cerrar_sesion').addEventListener('click', cerrarSesion);


async function cerrarSesion(event) {

    const token = localStorage.getItem('token') || sessionStorage.getItem('token');

    if (token) {
        const response = await fetch('http://localhost/proyectoPEPE/api.php', {
            method: 'POST',
            body: JSON.stringify({
                "action": "logout",
                "token": token
            })
        });
        const result = await response.json();

        sessionStorage.removeItem('token');
        localStorage.removeItem('token');
    }
    window.location.href = "/proyectoPEPE/";
}
