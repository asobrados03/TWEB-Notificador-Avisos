<?php include_once "inc/codigo_inicializacion.php"; ?>

<?php define("TITULO_PAGINA", "Publicar Avisos - Menu Profesor");?>

<?php $nombre = cabecera_nombre($conexionBD) ?>

<?php cabeceraPlantilla($nombre);?>

<?php
// Consulta para obtener la lista de estudiantes


$query = "SELECT NIA, Nombre FROM USUARIO WHERE NIA >= 100";
$resultado = $conexionBD->query($query);

// Verifica si la consulta fue exitosa
if ($resultado) {
    ?>

<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-4 text-center">Publicar Aviso</h1>
            <!-- Formulario para publicación de avisos -->
            <form action="procesar-registro-aviso.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormularioPA()>
                <div class="form-group">
                    <label for="titulo">Titulo: </label><br/>
                    <input type="text" class="form-control" id="Titulo" name="Titulo">
                </div>
                <div >
                    <label for="contenido">Contenido: </label>
                    <textarea class="form-control" rows="5" cols="30" name="Contenido" id="Contenido" maxlength="150"></textarea><br/>
                </div>
                <div class="form-group">
                    <label for="destinatario">Destinatario: </label>
                    <select class="form-control" id="Destinatario" name="Destinatario" multiple>
                        <option value="todos">Todos los estudiantes</option>
                        <?php
                            // Mostrar opciones de a que estudiante dirjimos el aviso
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<option value="' . $fila['NIA'] . '">' . $fila['Nombre'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button style="margin-top: 10px;" type="submit" class="btn btn-primary" name="submit" value="Submit">Publicar Aviso</button>
                </div>
                </form>
            </div>
        </div>
        <div class="text-center">
            <?php
                // Mostrar mensajes de importación
                $mensaje = isset($_SESSION['message_import']) ? $_SESSION['message_import'] : '';
                echo $mensaje;
                unset($_SESSION['message_import']);
            ?>
        </div>
    <?php
} else {
    $aviso = '<p>Error en la consulta: ' . $conexion->error . '</p>';
    echo $aviso;
} ?>
</section>

<?php piePlantilla();?>
<?php include_once "inc/codigo_finalizacion.php"; ?>