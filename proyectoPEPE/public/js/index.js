



$(document).ready(function(){
  $('.sidenav').sidenav();
});
document.addEventListener('DOMContentLoaded', function() {

  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, {});


  // Inicializa los modales de Materialize
  var modal1 = document.getElementById('modal1');
  var modal2 = document.getElementById('modal2');
  M.Modal.init(modal1);
  M.Modal.init(modal2);

  // Inicializa el formulario de inicio de sesión con Just Validate
  const validator = new JustValidate('#loginForm');
  validator.addField('#curp_login', [
    {
      rule: 'required',
      errorMessage:"Introduzca su CURP",
    },

    {
      rule: 'customRegexp',
      value: /^[A-Z\d]{18}$/,
      errorMessage:"Introduzca un CURP válido",
    }
  ]);

  validator.addField('#password_login', [
    {
      rule: 'required',
      errorMessage:"Introduzca su contraseña",
    },
    {
      rule: 'strongPassword',
      errorMessage:"Revisa que tu contraseña contenga un mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial. "
    },
  ]);

  validator.onSuccess( async (evt) => {
    evt.preventDefault();

    const curp = document.getElementById("curp_login").value;
    const pass = document.getElementById("password_login").value;
    const session = document.getElementById("active_session").checked;

    const response = await fetch('http://localhost/proyectoPEPE/api.php', {
      method: 'POST',
      body: JSON.stringify({
        "action": "login",
        "curp_login": curp,
        "password_login": pass
      })
    });
    const result = await response.json();

    if( result.error ) {
      return Swal.fire({
        title: 'Error',
        text: result.error,
        icon: 'error',
        didDestroy: () => {
          window.location.reload();
        }
      })
    }

    if ( result.data ) {
      if(session) {
        localStorage.setItem("token", result.data.token);
      } else {
        sessionStorage.setItem("token", result.data.token);
      }

      return Swal.fire({
        title: 'Exito!',
        text: result.data.message,
        icon: 'success',
        didDestroy: () => {
          window.location.href = "/proyectoPEPE/user";
        }
      })
    }

    return Swal.fire({
      title: 'Error desconocido!',
      text: "Error al procesar la respuesta del servidor.",
      icon: 'warning',
      didDestroy: () => {
        window.location.reload();
      }
    })


  });

  const validator2 = new JustValidate('#registerForm');

  validator2.addField('#curp_register', [
    {
      rule: 'required',
      errorMessage:"Introduzca su CURP",
    },

    {
      rule: 'customRegexp',
      value: /^[A-Z\d]{18}$/,
      errorMessage:"Introduzca un CURP válido",
    }
  ]);

  validator2.addField('#email_register', [
    {
      rule: 'required',
      errorMessage:"Introduzca su email",
    },

    {
      rule: 'customRegexp',
      value: '^(.+)@(\\S+)$' ,
      errorMessage: "Introduzca un email válido",
    },
  ]);

  validator2.addField('#password_register', [
    {
      rule: 'required',
      errorMessage:"Introduzca su contraseña",
    },
    {
      rule: 'customRegexp',
      value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
      errorMessage:"Revisa que tu contraseña contenga un mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (@$!%*?&). "
    },
  ])

  validator2.onSuccess( async (evt)=> {
    evt.preventDefault();
    const curp = document.getElementById("curp_register").value
    const email = document.getElementById("email_register").value
    const pass = document.getElementById("password_register").value

    const response = await fetch('http://localhost/proyectoPEPE/api.php', {
      method: 'POST',
      body: JSON.stringify({
        "action": "register",
        "curp_register": curp,
        "email_register": email,
        "password_register": pass
      })
    });
    const result = await response.json();

    if( result.error ) {
      return Swal.fire({
        title: 'Error',
        text: result.error,
        icon: 'error',
        didDestroy: () => {
          window.location.reload();
        }
      })
    }

    if ( result.data ) {
      return Swal.fire({
        title: 'Exito!',
        text: result.data.message,
        icon: 'success',
        didDestroy: () => {
          window.location.reload();
        }
      })
    }

    return Swal.fire({
      title: 'Error desconocido!',
      text: "Error al procesar la respuesta del servidor.",
      icon: 'warning',
      didDestroy: () => {
        window.location.reload();
      }
    })

  });


  // Abre el popup de inicio de sesión al hacer clic en el botón flotante
  var loginBtn = document.getElementById('loginBtn');
  loginBtn.addEventListener('click', function() {
    M.Modal.getInstance(modal1).open();
  });

  // Abre el popup de registro al hacer clic en el enlace de registro
  var registerLink = document.getElementById('registerLink');
  registerLink.addEventListener('click', function() {
    M.Modal.getInstance(modal1).close(); // Cierra el popup de inicio de sesión antes de abrir el de registro
    M.Modal.getInstance(modal2).open();
  });
});




