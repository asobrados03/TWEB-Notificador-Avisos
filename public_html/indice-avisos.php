<?php include_once "inc/codigo_inicializacion.php";?>

<?php define("TITULO_PAGINA", "Indice Avisos - Plataforma de Avisos");?>
<?php $nombre = cabecera_nombre($conexionBD);?>
<?php cabeceraPlantilla($nombre);?>

<?php
    $NIA = $_SESSION['NIA'];

    if ($NIA >= 100) {
        // Si el usuario es estudiante, entonces se hace el siguiente proceso
        $consulta2 = "SELECT Aviso FROM DIRIGIR_A_ESTUDIANTE WHERE Estudiante = ?";
        $sentencia2 = $conexionBD->prepare($consulta2);
        $sentencia2->bind_param("i", $NIA);
        $resultado2 = $sentencia2->execute();
    
        if ($resultado2) {
            $resultado2 = $sentencia2->get_result();
            // Verificar si la consulta devolvió un escalar o un conjunto de resultados
            if ($resultado2->num_rows == 1) {
                // Si hay una sola fila, obtener el valor escalar
                $fila = $resultado2->fetch_assoc();
                $idAviso = $fila['Aviso'];
            } elseif ($resultado2->num_rows > 1) {
                // Si hay varias filas, procesar el conjunto de resultados
                $idAviso = array();
                while ($fila = $resultado2->fetch_assoc()) {
                    // Acceder a la columna por nombre
                    $idAviso[] = $fila['Aviso'];
                }
            } else {
                $idAviso = 0;
            }
            // Liberar el resultado
            $resultado2->free_result();
        } else {
            $idAviso = 0;
        }
    
        $sentencia2->close();
    
        // Convertir $idAviso a una cadena para la consulta IN
        $idAvisoString = is_array($idAviso) ? implode(',', $idAviso) : $idAviso;
    
        $consulta1 = "SELECT * FROM AVISO WHERE IDAviso IN ($idAvisoString)";
        $resultado1 = mysqli_query($conexionBD, $consulta1);
    
        if ($resultado1->num_rows > 0) {
            // Almacenar los avisos en forma de lista
            $avisos = array();
    
            while ($fila = mysqli_fetch_assoc($resultado1)) {
                $avisos[] = $fila;
            }
        }
    } else {
        $consulta = "SELECT * FROM AVISO WHERE Profesor = $NIA";
        $resultado = mysqli_query($conexionBD, $consulta);
    
        if ($resultado->num_rows > 0) {
            // Almacenar los avisos en forma de lista
            $avisos = array();
    
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $avisos[] = $fila;
            }
        }
    }    
?>

<div class="container mt-5">
    <div id="lista-avisos">
        <?php
        // Mostrar los avisos en forma de lista
        if (isset($avisos) && !empty($avisos)) {
            foreach ($avisos as $aviso) {
                ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h3 class="card-title">
                                <?php echo $aviso['Titulo']; ?>
                            </h3>
                            <div class="text-end">
                                <p class="text-muted mb-0">
                                    Fecha: <?php echo $aviso['FechaPub'];?>
                                </p>
                            </div>
                        </div>
                        <div class="card-text">
                            <p class="text-sm">
                                <?php echo mb_substr($aviso['Contenido'], 0, 50, 'UTF-8'); ?>...
                            </p>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a class="btn btn-info" href="ver-aviso.php?id=<?php echo $aviso['IDAviso'];?>">
                                Leer Aviso
                            </a>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo '<h2 class= "display-4 text-center">No hay avisos disponibles.</h2>';
        }
        ?>

        <!-- Opción para filtrar los avisos Leidos y no Leidos exclusiva para estudiantes por la estructura de la BD -->
        <?php
            if($NIA >= 100){ ?>
                <div class="mb-3 text-center">
                    <label for="filtro-leido" class="form-label">Filtrar avisos:</label>
                    <div class="d-inline-block">
                        <select class="form-select form-select-sm" id="filtro-leido">
                            <option value="todos">Todos</option>
                            <option value="SI">Leído</option>
                            <option value="NO">No leído</option>
                        </select>
                    </div>
                </div>
            <?php
            }else{ ?>
                <div class="mb-3 text-center">
                    <label for="filtro-leido" class="form-label">Filtrar avisos:</label>
                    <div class="d-inline-block">
                        <select class="form-select form-select-sm" id="filtro-leido">
                            <option value="todos">Todos</option>
                            <option value="grupal">Grupales</option>
                            <option value="individual">Individuales</option>
                        </select>
                    </div>
                </div>
            <?php 
            }
        ?>
    </div>
</div>

<?php piePlantilla(); ?>
<?php include_once "inc/codigo_finalizacion.php"; ?>