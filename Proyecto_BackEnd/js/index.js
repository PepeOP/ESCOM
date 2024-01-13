$(document).ready(function(){
  $('.sidenav').sidenav();
});
document.addEventListener('DOMContentLoaded', function() {
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
      rule: 'strongPassword',
      errorMessage:"Revisa que tu contraseña contenga un mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial. "
    },
  ]);


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
  