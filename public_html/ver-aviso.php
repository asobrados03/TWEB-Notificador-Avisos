<?php
    include_once "inc/codigo_inicializacion.php";
    define("TITULO_PAGINA", "Visualizar Aviso - Plataforma de Avisos");
    $nombre = cabecera_nombre($conexionBD);
    cabeceraPlantilla($nombre);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['id'], $_SESSION['NIA'])) {
            $IDAviso = $_GET['id'];
            $NIA = $_SESSION['NIA'];

            $actualizacion = "UPDATE DIRIGIR_A_ESTUDIANTE SET Leido = 'SI' WHERE Estudiante = ? AND Aviso = ?";
            $sentenciaActualizacion = $conexionBD->prepare($actualizacion);

            $sentenciaActualizacion->bind_param("ii", $NIA, $IDAviso);
            $sentenciaActualizacion->execute();

            if (!$sentenciaActualizacion->execute()) {
                header('indice-avisos.php');
            }

            $sentenciaActualizacion->close();

            $consulta = "SELECT * FROM AVISO WHERE IDAviso = ?";
            $stmt = mysqli_prepare($conexionBD, $consulta);
            if($stmt){
                mysqli_stmt_bind_param($stmt, 'i', $IDAviso);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);
                if($resultado){
                    while ($fila = mysqli_fetch_assoc($resultado)){
                        $titulo = $fila['Titulo'];
                        $fecha = $fila['FechaPub'];
                        $contenido = $fila['Contenido'];
                        $profesor = $fila['Profesor'];
                    }
                }

            }
            mysqli_stmt_close($stmt);

            $consulta2 = "SELECT Nombre, Email FROM USUARIO WHERE NIA = ? ";
            $stmt = mysqli_prepare($conexionBD, $consulta2);
            if($stmt){
                mysqli_stmt_bind_param($stmt, 'i', $profesor);
                mysqli_stmt_execute($stmt);
                $resultado2 = mysqli_stmt_get_result($stmt);
                if($resultado2){
                    while ($fila = mysqli_fetch_assoc($resultado2)){
                        $nombreProf = $fila['Nombre'];
                        $emailProf = $fila['Email'];
                    }
                }
            }
            mysqli_stmt_close($stmt);

            //Comprobación de si el usuario es estudiante o profesor
            if($NIA >= 100){
                $consulta3 = "SELECT Nombre, Email FROM USUARIO WHERE NIA = ? ";
                $stmt = mysqli_prepare($conexionBD, $consulta3);
                if($stmt){
                    mysqli_stmt_bind_param($stmt, 'i', $NIA);
                    mysqli_stmt_execute($stmt);
                    $resultado3 = mysqli_stmt_get_result($stmt);
                    if($resultado3){
                        while ($fila = mysqli_fetch_assoc($resultado3)){
                            $nombreEstd = $fila['Nombre'];
                            $emailEstd = $fila['Email'];
                        }
                    }
                }
                mysqli_stmt_close($stmt);
            }else{
                $consulta3 = "SELECT Estudiante FROM DIRIGIR_A_ESTUDIANTE WHERE Aviso = ?";
                $stmt = mysqli_prepare($conexionBD, $consulta3);
                if($stmt){
                    mysqli_stmt_bind_param($stmt, 'i', $IDAviso);
                    mysqli_stmt_execute($stmt);
                    $resultado3 = mysqli_stmt_get_result($stmt);
                    if($resultado3){
                        $estudiantes = array();
                        while ($fila = mysqli_fetch_assoc($resultado3)){
                            array_push($estudiantes,$fila["Estudiante"]);
                        }
                        if (count($estudiantes) == 1) {
                            $estudiante = reset($estudiantes); // Obtener el único valor
                            $consultaSQL = "SELECT Nombre, Email FROM USUARIO WHERE NIA IN ($estudiante)";
                            $resultado4 = mysqli_query($conexionBD, $consultaSQL);
                            if($resultado4){
                                while ($fila = mysqli_fetch_assoc($resultado4)){
                                    $datosNombre = $fila['Nombre'];
                                    $datosEmail = $fila['Email'];
                                }
                            }
                            
                        } elseif (count($estudiantes) > 1) {
                            // El array tiene varios valores entonces el aviso es para todos los estudiantes
                            $comprobacion = true;
                            $destinatario = "Todos los estudiantes";
                        } else {
                            echo '<h3 class="alerta_error">Ha habido un problema en la Base de Datos!!</h3>';
                        }                        
                    }
                }
            }
            
        }
    }
?>

<div class = "container mt-5">
    <div class="card border bg-light text-dark shadow mb-4">
        <h3 class="ms-3 me-3"> <?php echo $titulo;?> <h3>
    </div>
    <?php if($NIA >= 100){ ?>
    <div class="card border bg-light text-dark shadow mb-4">
        <div class="ms-3 me-3">
            <p> Enviado por: <?php echo $nombreProf .' &lt;'. htmlspecialchars($emailProf) .'&gt;';?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> Para: <?php echo $nombreEstd .' &lt;'. htmlspecialchars($emailEstd) .'&gt;'; ?> </p>
        </div>
        <div class="position-absolute top-0 end-0 me-3">
            <p class="text-muted mb-0"> Fecha: <?php echo $fecha; ?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> <?php echo $contenido; ?> </p>
        </div>
        <div class="d-flex justify-content-center">
            <button style="margin-bottom: 5px" id="botonAtrasAviso" type="button" class="btn btn-success">Atrás</button>
        </div>
    </div>
    <?php } elseif(!$comprobacion){ ?>
    <div class="card border bg-light text-dark shadow mb-4">
        <div class="ms-3 me-3">
            <p> Enviado por: <?php echo $nombreProf .' &lt;'. htmlspecialchars($emailProf) .'&gt;';?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> Para: <?php echo $datosNombre .' &lt;'. htmlspecialchars($datosEmail) .'&gt;'; ?> </p>
        </div>
        <div class="position-absolute top-0 end-0 me-3">
            <p class="text-muted mb-0"> Fecha: <?php echo $fecha; ?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> <?php echo $contenido; ?> </p>
        </div>
        <div class="d-flex justify-content-center">
            <button style="margin-bottom: 5px" id="botonAtrasAviso" type="button" class="btn btn-success">Atrás</button>
        </div>
    </div>

    <?php } else { ?>
    <div class="card border bg-light text-dark shadow mb-4">
        <div class="ms-3 me-3">
            <p> Enviado por: <?php echo $nombreProf .' &lt;'. htmlspecialchars($emailProf) .'&gt;';?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> Para: <?php echo $destinatario; ?> </p>
        </div>
        <div class="position-absolute top-0 end-0 me-3">
            <p class="text-muted mb-0"> Fecha: <?php echo $fecha; ?> </p>
        </div>
        <div class="ms-3 me-3">
            <p> <?php echo $contenido; ?> </p>
        </div>
        <div class="d-flex justify-content-center">
            <button style="margin-bottom: 5px" id="botonAtrasAviso" type="button" class="btn btn-success">Atrás</button>
        </div>
    </div>
    <?php } ?>
</div>

<?php
    piePlantilla();
    include_once "inc/codigo_finalizacion.php";
?>