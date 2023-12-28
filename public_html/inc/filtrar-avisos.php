<?php
    include_once "../../conexionBD/conexion_BD.php";
    include_once "./codigo_inicializacion.php";

    // Obtener el valor del filtro desde la solicitud AJAX
    $filtro = $_POST['filtro'];

    // Verificar si la variable $NIA está definida
    if (!isset($NIA)) {
        $NIA = $_SESSION['NIA'];
    }

    if($NIA >= 100){
        // Consulta para obtener los avisos filtrados por leído/no leído
        $consulta = "SELECT * FROM AVISO AS a
        JOIN DIRIGIR_A_ESTUDIANTE AS de
        ON a.IDAviso = de.Aviso
        WHERE de.Leido = '$filtro'
        AND de.Estudiante = ?";

        // Utilizar una consulta preparada
        $sentencia = $conexionBD->prepare($consulta);
        $sentencia->bind_param("i", $NIA);
        $sentencia->execute();

        $resultados = $sentencia->get_result();

        // Almacenar los resultados en forma de lista
        $avisos = array();

        while ($row = $resultados->fetch_assoc()) {
            $avisos[] = $row;
        }

        $resultados->free_result();
        $sentencia->close();
    }else{
        // Consulta para obtener los avisos filtrados por grupales

        // Construir la consulta base
        $consultaBase = "SELECT DISTINCT a.IDAviso, a.Profesor, a.Titulo, a.Contenido, a.FechaPub
        FROM AVISO AS a
        JOIN DIRIGIR_A_ESTUDIANTE AS de
        ON a.IDAviso = de.Aviso";

        // Construir la cláusula HAVING dinámicamente según el filtro
        $havingClause = ($filtro == "grupal") ? "> 1" : "= 1";

        // Construir la consulta completa
        $consulta = "$consultaBase
        WHERE a.IDAviso IN (
            SELECT a.IDAviso
            FROM AVISO AS a
            JOIN DIRIGIR_A_ESTUDIANTE AS de
            ON a.IDAviso = de.Aviso
            GROUP BY a.IDAviso
            HAVING COUNT(a.IDAviso) $havingClause
        )";

        $resultados = $conexionBD->query($consulta);

        // Almacenar los resultados en forma de lista
        $avisos = array();

        while ($row = $resultados->fetch_assoc()) {
            $avisos[] = $row;
        }

        // Cerrar y liberar resultados
        $resultados->free_result();
    }

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
                        <a class="btn btn-info" href="../ver-aviso.php?id=<?php echo $aviso['IDAviso'];?>">
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

    include_once "./codigo_finalizacion.php";
?>
<div class="d-flex justify-content-center mb-3">
    <button type="button" class="btn btn-success" onclick="window.location.href='../indice-avisos.php'">Quitar filtro</button>
</div>