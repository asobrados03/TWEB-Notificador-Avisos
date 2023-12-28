<?php include_once "inc/codigo_inicializacion.php"; ?>

<?php define("TITULO_PAGINA", "Registrar Estudiantes - Menu Profesor");?>

<?php $nombre = cabecera_nombre($conexionBD) ?>

<?php cabeceraPlantilla($nombre);?>

<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex justify-content-center align-items-center" style="height: 15vh;" >
                <h1 class="display-4">Registro de estudiantes</h1>
            </div>
            <form action="procesar-registro-estudiante.php" method="POST" onsubmit="return validarFormularioRE()">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Estudiante" required title="Por favor, ingrese el nombre">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email del Estudiante" required title="Por favor, ingrese el correo electrónico">
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña del Estudiante" minlength="6" maxlength="12" required title="Por favor, ingrese la contraseña provisional">
                </div>
                <div class="d-flex justify-content-center">
                    <button style="margin-top: 10px;" type="submit" class="btn btn-primary" name="submit" value="Submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        // Mostrar mensajes de importación
        $mensaje = isset($_SESSION['message_import']) ? $_SESSION['message_import'] : '';
        echo $mensaje;
        unset($_SESSION['message_import']);
    ?>
</section>
 
<?php piePlantilla(); ?>
<?php include_once "inc/codigo_finalizacion.php"; ?>