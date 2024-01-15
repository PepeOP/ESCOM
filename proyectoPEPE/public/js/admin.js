console.log("SMITE");


document.addEventListener('DOMContentLoaded', async function() {

    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);


    // Inicializa los modales de Materialize
    var modal1 = document.getElementById('modal-add-new');
    M.Modal.init(modal1);
    var modal2 = document.getElementById('modal-edit');
    M.Modal.init(modal2);


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
                "action": "validateTokenAdmin",
                "token": token
            })
        });
        const result = await response.json();


        if( result.data ) {
            if ( !result.data.is_valid ) {
                window.location.href = "/proyectoPEPE/";
                return;
            }
        }
    }


});


document.getElementById('create_user_btn').addEventListener('click', createUser);

async function createUser(event) {
    event.preventDefault();

    const token = localStorage.getItem('token') || sessionStorage.getItem('token');

    const name = document.getElementById("nombre").value;
    const dependencia = document.getElementById("dependencia").value;
    const distinciones = document.getElementById("distinciones").value;
    const categoria = document.getElementById("categoria").value;
    const curp = document.getElementById("curp").value;



    if(token) {
        const response = await fetch('http://localhost/proyectoPEPE/api.php', {
            method: 'POST',
            body: JSON.stringify({
                "action": "addNewUser",
                "token": token,
                "nombre": name,
                "dependencia": dependencia,
                "distincion": distinciones,
                "categoria": categoria,
                "curp": curp
            })
        });

        const result = await response.json();
        console.log(result);

        if( result.data ) {
            Swal.fire({
                title: 'Usuario creado',
                text: result.data.message,
                icon: 'success',
                didDestroy: () => {
                    window.location.reload();
                }
            });
        }

        if( result.error) {
            Swal.fire({
                title: 'Error',
                text: result.error,
                icon: 'error',
                didDestroy: () => {
                    window.location.reload();
                }
            });
        }
    }

}


async function eliminarUsuario(no, categoria) {

    try {
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');

        console.log(no);
        console.log(categoria);

        const response = await fetch('http://localhost/proyectoPEPE/api.php', {
            method: 'POST',
            body: JSON.stringify({
                "action": "deleteUser",
                "token": token,
                "id": no,
                "category": categoria.toLowerCase()
            })
        });
        const result = await response.json();
        console.log(result);

        Swal.fire({
            title: 'Exito',
            text: result.data.message,
            icon: 'success',
            didDestroy: () => {
                window.location.reload();
            }
        });

    } catch (e) {
        console.log(e);
        Swal.fire({
            title: 'Error',
            text: 'Error al procesar el request para eliminar el usuario',
            icon: 'error',
            didDestroy: () => {
                window.location.reload();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Obtener todos los botones de eliminar
    const deleteButtons = document.querySelectorAll('[data-role="delete"]');

    // Añadir un evento de clic a cada botón
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Recuperar los valores de los atributos de datos
            const no = this.getAttribute('data-no');
            const categoria = this.getAttribute('data-categoria');

            // Llamar a la función eliminarAdmin con los valores recuperados
            eliminarUsuario(no, categoria);
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    var editButtons = document.querySelectorAll('[data-role="editar"]');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtener los datos
            var no = this.getAttribute('data-no');
            var nombre = this.getAttribute('data-nombre');
            var dependencia = this.getAttribute('data-dependencia');
            var distincion = this.getAttribute('data-distincion');
            var categoria = this.getAttribute('data-categoria');
            var curp = this.getAttribute('data-curp');

            // Precargar los datos en el modal
            document.getElementById('nombre-editar').value = nombre;
            // document.getElementById('dependencia-editar').value = dependencia;
            // document.getElementById('distinciones-editar').value = distincion;
            document.getElementById('categoria-editar').value = categoria;
            document.getElementById('curp-editar').value = curp;
            document.getElementById('no-editar').value = no;

            // Abrir el modal
            var instance = M.Modal.getInstance(document.getElementById('modal-edit'));
            instance.open();
        });
    });
});


document.getElementById('edit_user_btn').addEventListener('click', async function(event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    const dependencia = document.getElementById("dependencia-editar").value;
    const distinciones = document.getElementById("distinciones-editar").value;
    const categoria = document.getElementById("categoria-editar").value;
    const no = document.getElementById("no-editar").value;

    console.log("NO: ", no);


    const response = await fetch('http://localhost/proyectoPEPE/api.php', {
        method: 'POST',
        body: JSON.stringify({
            "action": "editUser",
            "id": no,
            "dependencia": dependencia,
            "distincion": distinciones,
            "categoria": categoria
        })
    });
    const result = await response.json();

    if( result.data ) {
        Swal.fire({
            title: 'Usuario editado',
            text: result.data.message,
            icon: 'success',
            didDestroy: () => {
                window.location.reload();
            }
        });
    }

    if ( result.error ) {
        Swal.fire({
            title: 'Error',
            text: result.error,
            icon: 'error',
            didDestroy: () => {
                window.location.reload();
            }
        });
    }

    // Aquí puedes agregar más lógica, como enviar los datos del formulario
});