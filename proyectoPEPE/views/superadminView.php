

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="public/js/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="public/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="public/materialize/css/materialize.min.css">
    <script src="public/js/just-validate.production.min.js"></script>
    <link href="public/css/material_icons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <script src="public/js/sweetalert_min.js"></script>

    <script src="public/fontawesome-free-6.4.2-web/js/all.min.js"></script>
    <script src="public/materialize/js/materialize.min.js"></script>
    <script type="module" src="public/js/index.js"></script>
    <script type="module" src="public/js/admin.js"></script>
    <title>DMP</title>
</head>

<header>
    <nav class="nav-extended font hide-on-small-only">
        <div class="nav-wrapper">
            <a href="/" class="brand-logo center">Instituto Politécnico Nacional</a>
        </div>
        <div class="nav-content">
            <ul class="tabs tabs-transparent">
                <li class="tab"><a href="/">Inicio</a></li>
                <li class="tab"><a class="modal-trigger" href="">Cerrar Sesión</a></li>
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


<main>
    <div class="col s12 m12 l6 right">
        <a href="https://www.ipn.mx/directorio-telefonico.html" class="black-text">DIRECTORIO</a> |
        <a href="https://www.ipn.mx/correo-electronico.html" class="black-text">CORREO</a> |
        <a href="https://www.ipn.mx/calendario-academico.html" class="black-text">CALENDARIO</a> |
        <a href="https://www.ipn.mx/transparencia/" class="black-text">TRANSPARENCIA</a> |
        <a href="https://www.ipn.mx/proteccion-datos-personales/" class="black-text">PROTECCIÓN DE DATOS</a>
    </div>
    <div class="col s12 m12 l6">
        <div class="">
            <a href="https://www.gob.mx/sep">
                <img src="public/images/pleca-gob.png" alt="Pleca de Gobierno" class="">
            </a>
        </div>
    </div>


    <div class="row">
        <img src="public/images/dmp.jpg" alt="" class="responsive-img">
    </div>


    <button class="btn green modal-trigger" data-target="modal-add-new">Añadir Nuevo</button>
    <h3>Administrativos</h3>
    <table class="highlight responsive-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Dependencia</th>
            <th>Distinción</th>
<!--            <th>Categoría</th>-->
            <th>CURP</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($administrativos as $admin): ?>
            <tr>
                <td><?php echo htmlspecialchars($admin['no']); ?></td>
                <td><?php echo htmlspecialchars($admin['nombre']); ?></td>
                <td><?php echo htmlspecialchars($admin['dependencia']); ?></td>
                <td><?php echo htmlspecialchars($admin['distincion']); ?></td>
<!--                <td>--><?php //echo htmlspecialchars($admin['categoria']); ?><!--</td>-->
                <td><?php echo htmlspecialchars($admin['curp']); ?></td>
                <td>
                    <button class="btn-small blue modal-trigger"
                            data-role="editar"
                            data-no="<?php echo htmlspecialchars($admin['no']); ?>"
                            data-nombre="<?php echo htmlspecialchars($admin['nombre']); ?>"
                            data-dependencia="<?php echo htmlspecialchars($admin['dependencia']); ?>"
                            data-distincion="<?php echo htmlspecialchars($admin['distincion']); ?>"
                            data-categoria="<?php echo htmlspecialchars($admin['categoria']); ?>"
                            data-curp="<?php echo htmlspecialchars($admin['curp']); ?>"
                            data-target="modal-edit"
                    >Editar</button>
                    <button class="btn-small red"
                            data-role="delete"
                            data-no="<?php echo htmlspecialchars($admin['no']); ?>"
                            data-categoria="<?php echo htmlspecialchars($admin['categoria']); ?>">
                        Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <button class="btn green modal-trigger" data-target="modal-add-new">Añadir Nuevo</button>
    <h3>Docentes</h3>
    <table class="highlight responsive-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Dependencia</th>
            <th>Distinción</th>
<!--            <th>Categoría</th>-->
            <th>CURP</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($docentes as $docente): ?>
            <tr>
                <td><?php echo htmlspecialchars($docente['no']); ?></td>
                <td><?php echo htmlspecialchars($docente['nombre']); ?></td>
                <td><?php echo htmlspecialchars($docente['dependencia']); ?></td>
                <td><?php echo htmlspecialchars($docente['distincion']); ?></td>
<!--                <td>--><?php //echo htmlspecialchars($docente['categoria']); ?><!--</td>-->
                <td><?php echo htmlspecialchars($docente['curp']); ?></td>
                <td>
                    <button class="btn-small blue modal-trigger"
                            data-role="editar"
                            data-no="<?php echo htmlspecialchars($docente['no']); ?>"
                            data-nombre="<?php echo htmlspecialchars($docente['nombre']); ?>"
                            data-dependencia="<?php echo htmlspecialchars($docente['dependencia']); ?>"
                            data-distincion="<?php echo htmlspecialchars($docente['distincion']); ?>"
                            data-categoria="<?php echo htmlspecialchars($docente['categoria']); ?>"
                            data-curp="<?php echo htmlspecialchars($docente['curp']); ?>"
                            data-target="modal-edit"
                    >Editar</button>
                    <button class="btn-small red"
                            data-role="delete"
                            data-no="<?php echo htmlspecialchars($docente['no']); ?>"
                            data-categoria="<?php echo htmlspecialchars($docente['categoria']); ?>">
                        Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Confirmacion de asistencias</h3>
    <table class="highlight responsive-table">
        <thead>
        <tr>
            <th>CURP</th>
            <th>Hay invitados?</th>
            <th>Asistencia</th>
            <th>Razon de la asistencia</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($asistencias as $asistencia): ?>
            <tr>
                <td><?php echo htmlspecialchars($asistencia['curp']); ?></td>
                <td><?php echo $asistencia['guests'] == 1 ? "Sí" : "No"; ?></td>
                <td><?php echo $asistencia['disability'] == 1 ? "Sí" : "No"; ?></td>
                <td><?php echo htmlspecialchars($asistencia['disability_reason']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>




</main>

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


<!-- Estructura del Modal -->
<div id="modal-add-new" class="modal">
    <div class="modal-content">
        <h4>Añadir Nuevo Registro</h4>
        <form>
            <input type="hidden" name="action" value="addNewUser">
            <div class="input-field">
                <input id="nombre" type="text" name="nombre" required>
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field">
                <select id="dependencia" name="dependencia" required>
                    <?php foreach ($dependencias as $dep): ?>
                        <option value="<?php echo htmlspecialchars($dep['dependencia']);?>"><?php echo htmlspecialchars($dep['dependencia']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="dependencia">Dependencia</label>
            </div>
            <div class="input-field">
                <select id="distinciones" name="distincion" required>
                    <?php foreach ($distinciones as $dis): ?>
                        <option value="<?php echo htmlspecialchars($dis['distincion']);?>"><?php echo htmlspecialchars($dis['distincion']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="distincion">Distincion</label>
            </div>
            <div class="input-field col s12">
                <select id="categoria" name="categoria" required>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Docente">Docente</option>
                </select>
                <label for="categoria">Categoria</label>
            </div>
            <div class="input-field">
                <input id="curp" type="text" name="curp" required>
                <label for="curp">CURP</label>
            </div>
            <button type="submit" class="btn blue" id="create_user_btn">Agregar</button>
        </form>
    </div>
</div>

<div id="modal-edit" class="modal">
    <div class="modal-content">
        <h4>Editar Registro</h4>
        <form>
            <input type="hidden" name="action" value="addNewUser">
            <input type="hidden" id="no-editar" value="">
            <div class="input-field">
                <input id="nombre-editar" type="text" name="nombre-editar" disabled>
<!--                <label for="nombre-editar">Nombre</label>-->
            </div>
            <div class="input-field">
                <select id="dependencia-editar" name="dependencia-editar" required>
                    <?php foreach ($dependencias1 as $dep): ?>
                        <option value="<?php echo htmlspecialchars($dep['dependencia']);?>"><?php echo htmlspecialchars($dep['dependencia']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="dependencia">Dependencia</label>
            </div>
            <div class="input-field">
                <select id="distinciones-editar" name="distinciones-editar" required>
                    <?php foreach ($distinciones1 as $dis): ?>
                        <option value="<?php echo htmlspecialchars($dis['distincion']);?>"><?php echo htmlspecialchars($dis['distincion']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="distinciones-editar">Distincion</label>
            </div>
            <div class="input-field col s12 hide">
                <select id="categoria-editar" name="categoria-editar" disabled>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Docente">Docente</option>
                </select>
                <label for="categoria-editar">Categoria</label>
            </div>
            <div class="input-field">
                <input id="curp-editar" type="text" name="curp-editar" disabled>
<!--                <label for="curp-editar">CURP</label>-->
            </div>
            <button type="submit" class="btn blue" id="edit_user_btn">Editar</button>
        </form>
    </div>
</div>

</html>