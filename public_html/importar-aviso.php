<?php
    include_once "inc/codigo_inicializacion.php";
    define("TITULO_PAGINA", "Importar Aviso - Plataforma de Avisos");
    $nombre = cabecera_nombre($conexionBD);
    cabeceraPlantilla($nombre);
?>

<div class="container mt-5">
    <form enctype="multipart/form-data" action="aviso-csv.php" method="POST" onsubmit="return validarFormularioImportar()">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />

        <div class="mb-3">
            <label for="fichero_usuario" class="form-label">Seleccionar fichero:</label>
            <input type="file" class="form-control" id="fichero_usuario" name="fichero_usuario" />
        </div>

        <button id="importacion" type="submit" class="btn btn-warning">Enviar fichero</button>
    </form>

    <?php
        // Mostrar mensajes de importación
        $mensaje = isset($_SESSION['message_import']) ? $_SESSION['message_import'] : '';
        echo $mensaje;
        unset($_SESSION['message_import']);
    ?>
</div>

<?php piePlantilla();?>
<?php include_once "inc/codigo_finalizacion.php"; ?>