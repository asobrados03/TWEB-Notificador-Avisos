<?php include_once "inc/codigo_inicializacion.php";?>

<?php define("TITULO_PAGINA", "Leer Avisos Importados - Plataforma de Avisos");?>
<?php $nombre = cabecera_nombre($conexionBD);?>
<?php cabeceraPlantilla($nombre);?>

<div class="container mt-5">
    <?php
        // Ruta del directorio que contiene los archivos CSV
        $uploadsDir = "../uploads/";

        // Patrón para buscar archivos CSV
        $csvPattern = $uploadsDir . "*.csv";

        // Obtener la lista de archivos que coinciden con el patrón
        $csvFiles = glob($csvPattern);

        // Verificar si se encontraron archivos CSV
        if ($csvFiles) {
            // Iterar sobre cada archivo CSV
            foreach ($csvFiles as $csvFile) {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Archivo CSV: <?php echo $csvFile; ?></h5>

                        <?php
                        // Abrir el archivo en modo lectura
                        $fp = fopen($csvFile, "r");

                        // Variable para realizar un seguimiento de si ya se leyó la primera fila
                        $primeraFilaLeida = false;

                        // Verificar si se abrió correctamente
                        if ($fp) {
                            ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NIA del Profesor</th>
                                        <th scope="col">Nombre del Estudiante</th>
                                        <th scope="col">Asunto</th>
                                        <th scope="col">Contenido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Iterar sobre las filas del archivo CSV
                                    while (($data = fgetcsv($fp, 1000, ";")) !== false) {
                                        // Verificar si ya se leyó la primera fila
                                        if (!$primeraFilaLeida) {
                                            $primeraFilaLeida = true;
                                            continue; // Saltar la primera fila
                                        }
                                        ?>
                                        <tr>
                                            <?php
                                            // Imprimir cada elemento de la fila
                                            foreach ($data as $element) {
                                                echo "<td>{$element}</td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php

                            // Cerrar el archivo después de leerlo
                            fclose($fp);
                        } else {
                            echo "<p class='text-danger'>Error al abrir el archivo CSV: {$csvFile}</p>";
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='lead'>No se encontraron archivos CSV en la carpeta uploads.</p>";
        }
    ?>
</div>

<?php piePlantilla(); ?>
<?php include_once "inc/codigo_finalizacion.php"; ?>