<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="public/materialize/css/materialize.min.css">
    <link href="public/css/material_icons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/user.css">


    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="public/materialize/js/materialize.min.js"></script>
    <script src="public/js/just-validate.production.min.js"></script>
    <script src="public/fontawesome-free-6.4.2-web/js/all.min.js"></script>
    <script src="public/materialize/js/materialize.min.js"></script>
    <script src="public/js/sweetalert_min.js"></script>
    <script src="public/js/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script type="module" src="public/js/user.js"></script>

    <title>DMP</title>
</head>
<header>
    <nav class="nav-extended font hide-on-small-only">
        <div class="nav-wrapper">
            <a href="/" class="brand-logo center">Instituto Politécnico Nacional</a>
        </div>
        <div class="nav-content">
            <ul class="tabs tabs-transparent">
                <li class="tab"><a href="#" id="cerrar_sesion" >Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <nav class="nav-extended font hide-on-med-and-up">
        <div class="nav-wrapper">
            <a href="public/index.html" class="brand-logo center">IPN</a>
        </div>
        <div class="nav-content">
            <ul class="tabs tabs-transparent">
                <li class="tab"><a href="/">Inicio</a></li>
                <li class="tab"><a href="">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
</header>

<body>
<main>
    <div class="fixed-action-btn">
        <a id="scrollToTop" class="btn-floating btn-large font">
            <i class="large material-icons menu-icon">menu</i>
            <i class="large material-icons arrow-icon">arrow_upward</i>
        </a>
        <ul>
            <li>
                <a href="#confirmacionModal" class="btn-floating modal-trigger" id="confirmacionElement">
                    <i class="material-icons large">redeem</i>
                </a>
            </li>
        </ul>
    </div>

    <div id="confirmacionModal" class="modal font2">
        <div class="modal-content">
            <h4 class="white-text">Confirmación de Asistencia</h4>
            <form id="confirmacionForm">
                <p>
                    <label>
                        <input id="confirmacion_si" name="confirmacion" type="radio" value="si" class="with-gap" required>
                        <span class="white-text">Asistiré</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input id="confirmacion_no" name="confirmacion" type="radio" value="no" class="with-gap" required>
                        <span class="white-text">No podré asistir</span>
                    </label>
                </p>
                <button class="btn waves-effect waves-light font" type="submit">Confirmar</button>
            </form>
        </div>
    </div>

    <!-- Modal de Invitación -->
    <div id="invitacionModal" class="modal font2">
        <div class="modal-content">
            <h4 class="white-text">Datos e Invitación</h4>
            <form id="invitacionForm">

                <p class="white-text">¿Usted llevará algún invitado?</p>
                <p>
                    <label>
                        <input id="llevarInvitado_si" name="llevarInvitado" type="radio" value="si" class="with-gap" required>
                        <span class="white-text">Sí, llevaré un invitado</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input id="llevarInvitado_no" name="llevarInvitado" type="radio" value="no" class="with-gap" required>
                        <span class="white-text">No, no llevaré invitado</span>
                    </label>
                </p>

                <p class="white-text">¿Usted sufre de alguna discapacidad?</p>
                <p>
                    <label>
                        <input id="discapacidad_si" name="discapacidad" type="radio" value="si" class="with-gap" required>
                        <span class="white-text">Sí, tengo discapacidad</span>
                    </label>
                </p>

                <div class="input-field col s6">
                    <input placeholder="Razon de tu discapacidad" id="disability_reason" name="disability_reason" type="text" class="validate">
                    <label for="disability_reason">Cual es tu discapacidad?</label>
                </div>

                <p>
                    <label>
                        <input id="discapacidad_no" name="discapacidad" type="radio" value="no" class="with-gap" required>
                        <span class="white-text">No, no tengo discapacidad</span>
                    </label>
                </p>
                <button id="invitacionSubmit" class="btn waves-effect waves-light font" type="submit">Generar Invitación</button>
            </form>
        </div>
    </div>

    <div class="col s12 m12 l6 right">
        <a href="https://www.ipn.mx/directorio-telefonico.html" class="black-text" target="_blank">DIRECTORIO</a> |
        <a href="https://www.ipn.mx/correo-electronico.html" class="black-text" target="_blank">CORREO</a> |
        <a href="https://www.ipn.mx/calendario-academico.html" class="black-text" target="_blank">CALENDARIO</a> |
        <a href="https://www.ipn.mx/transparencia/" class="black-text" target="_blank">TRANSPARENCIA</a> |
        <a href="https://www.ipn.mx/proteccion-datos-personales/" class="black-text" target="_blank">PROTECCIÓN DE DATOS</a>
    </div>
    <div class="col s12 m12 l6">
        <div class="">
            <a href="https://www.gob.mx/sep">
                <img src="public/images/pleca-gob.png" alt="Pleca de Gobierno" class="responsive-img">
            </a>
        </div>
    </div>


    <div class="row">
        <img src="public/images/dmp.jpg" alt="" class="responsive-img">
    </div>



    <div class="container">
        <!-- Administrativos -->
        <h4 id="tituloAdministrativos">Administrativos</h4>
        <ul id="listaAdministrativos" class="collection">
            <!-- Los elementos se añadirán aquí dinámicamente -->
        </ul>

        <!-- Docentes -->
        <h4 id="tituloDocentes">Docentes</h4>
        <ul id="listaDocentes" class="collection">
            <!-- Los elementos se añadirán aquí dinámicamente -->
        </ul>
    </div>

    <div class="container center">
        <button class="modal-trigger" id="confirmacionElement" href="#confirmacionModal">
            <i class="material-icons large">redeem</i>
        </button>
    </div>



</main>
</body>



<footer>
    <div class="grey darken-3 white-text">
        <div class="container">
            <div class="row">
                <div class="col l12">
                    <h3 class="center flow-text">INSTITUTO POLITÉCNICO NACIONAL</h3>
                    <p>
                        D.R. Instituto Politécnico Nacional (IPN). Av. Luis Enrique Erro S/N, Unidad Profesional Adolfo López Mateos, Zacatenco, Alcaldía Gustavo A. Madero, C.P. 07738, Ciudad de México. Conmutador: 55 57 29 60 00 / 55 57 29 63 00.
                    </p>
                    <br>
                    <p>
                        Esta página es una obra intelectual protegida por la Ley Federal del Derecho de Autor, puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica; su uso para otros fines, requiere autorización previa y por escrito de la Dirección General del Instituto.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 pl-7">
                    <img src="public/images/educacion2.png" alt="SEP" class="EducacionplecaGob gob">
                </div>
            </div>
        </div>
    </div>
</footer>
</html>