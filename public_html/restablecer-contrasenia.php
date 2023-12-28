<?php
    include_once "inc/codigo_inicializacion.php";

    define("TITULO_PAGINA", "Restablecer Contraseña - Plataforma de Avisos");

    $NIA = $_SESSION['NIA'];

    $nombre = cabecera_nombre($conexionBD);
    cabeceraPlantilla($nombre);
?>

<div style="min-height: 80vh;">
    <div class="d-flex justify-content-center align-items-center" style="height: 15vh;">
        <h1 class="display-3">Restablecer Contraseña</h1>
    </div>

    <div class="container ajustar2">
        <form method="POST" action="procesar-restablecer-contrasenia.php" onsubmit="return validarFormularioRC()">
            <div class="form-group" style="background-color: rgba(255, 255, 255, 0.5);">
                <label for="nueva_contrasena">Nueva contraseña</label>
                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" placeholder="Introduce Tú Nueva Contraseña" minlength="6" maxlength="12" required title="Por favor, ingrese su nueva contraseña">
            </div>

            <div class="form-group" style="background-color: rgba(255, 255, 255, 0.5);">
                <label for="confirmar_contrasena">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirma Tú Contraseña" minlength="6" maxlength="12" required title="Por favor, confirme su contraseña">
            </div>

            <div class="d-flex justify-content-center">
                <button style="margin-top: 10px;" type="submit" class="btn btn-primary" name="submit" value="Submit">Restablecer Contraseña</button>
            </div>
        </form>
    </div>
    <?php
        // Mostrar mensajes de importación
        $mensaje = isset($_SESSION['message_import']) ? $_SESSION['message_import'] : '';
        echo $mensaje;
        unset($_SESSION['message_import']);
    ?>
</div>

<?php
    piePlantilla();
    include_once "inc/codigo_finalizacion.php";
?>
