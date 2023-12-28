<?php
    include_once "inc/codigo_inicializacion.php";

    // Definir las variables e inicializarlas a vacío
    $titulo = $contenido = $NIA = $fechaPub = "";

    // Comprobar la entrada del inicio de sesión de la app
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["Titulo"], $_POST["Contenido"], $_POST["Destinatario"])) {
            $titulo = comprobar_entrada($conexionBD, $_POST["Titulo"]);
            $contenido = comprobar_entrada($conexionBD, $_POST["Contenido"]);
            $destinatario = comprobar_entrada($conexionBD, $_POST["Destinatario"]); //Aqui pasa algo que no esta bien revisar

            //Fecha actual de la publicación del aviso
            $fechaPub = date('Y-m-d');

            //Profesor que realiza el registro del Aviso
            $NIA = $_SESSION['NIA'];

            // Consulta para insertar el nuevo aviso preparada para evitar inyección de SQL
            $sentenciaSQL = "INSERT INTO AVISO (Titulo, Contenido, Profesor, FechaPub) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexionBD, $sentenciaSQL);

            if ($stmt) {
                // Vincular parámetros
                mysqli_stmt_bind_param($stmt, "ssis", $titulo, $contenido, $NIA, $fechaPub);

                // Ejecutar la consulta
                $resultado = mysqli_stmt_execute($stmt);

                if (!$resultado) {
                    $message_import = '<p>Error al ejecutar la consulta preparada: ' . mysqli_stmt_error($stmt) . '</p>';
                    $_SESSION['message_import'] = $message_import;
                    header("Location: publicar-aviso.php");
                    exit;
                }

                // Cerrar la consulta preparada
                mysqli_stmt_close($stmt);
            } else {
                $message_import = '<p>Error en la preparación de la consulta: ' . mysqli_error($conexionBD) . '</p>';
                $_SESSION['message_import'] = $message_import;
                header("Location: publicar-aviso.php");
                exit;
            }

            // Codigo para dirigir el aviso a un estudiante o a todos

            // Verifica el destinatario seleccionado
            if ($destinatario === 'todos') {
                // Seleccionado "Todos los estudiantes"

                // Obtener el ID del aviso recién insertado
                $idAvisoInsertado = $conexionBD->insert_id;

                // Aviso dirigido a todos los estudiantes
                $queryEstudiantes = "SELECT NIA FROM USUARIO WHERE NIA >= 100";
                $stmtEstudiantes = $conexionBD->prepare($queryEstudiantes);

                if ($stmtEstudiantes) {
                    $stmtEstudiantes->execute();
                    $resultadoEstudiantes = $stmtEstudiantes->get_result();

                    // Preparar la consulta fuera del bucle
                    $queryDirigir = "INSERT INTO DIRIGIR_A_ESTUDIANTE (Estudiante, Aviso, Leido) VALUES (?, ?, 'NO')";
                    $stmtDirigir = $conexionBD->prepare($queryDirigir);

                    while ($fila = $resultadoEstudiantes->fetch_assoc()) {
                        // En lugar de preparar una nueva consulta, solo cambia los parámetros y ejecuta la misma consulta preparada
                        if ($stmtDirigir) {
                            $stmtDirigir->bind_param("ii", $fila['NIA'], $idAvisoInsertado);
                            $stmtDirigir->execute();
                        } else {
                            // Manejar error en la preparación de la consulta
                            $message_import = '<p>Error al preparar la consulta: ' . $conexionBD->error . '</p>';
                            $_SESSION['message_import'] = $message_import;
                            header("Location: publicar-aviso.php");
                            exit;
                        }
                    }

                    // Cerrar la consulta preparada fuera del bucle
                    $stmtDirigir->close();
                    
                    $stmtEstudiantes->close();
                } else {
                    // Manejar error en la preparación de la consulta
                    $message_import = '<p>Error al preparar la consulta: ' . $conexionBD->error . '</p>';
                    $_SESSION['message_import'] = $message_import;
                    header("Location: publicar-aviso.php");
                    exit;
                }

            } else {
                // Seleccionado un estudiante específico

                // Utiliza $destinatario directamente como el NIA del estudiante seleccionado
                $NIA = $destinatario;

                // Obtener el ID del aviso recién insertado
                $idAvisoInsertado = $conexionBD->insert_id;

                // Insertar registros en DIRIGIR_A_ESTUDIANTE para el estudiante seleccionado
                $queryInsertDirigir = "INSERT INTO DIRIGIR_A_ESTUDIANTE (Estudiante, Aviso, Leido) VALUES (?, ?, 'NO')";
                $stmtInsertDirigir = $conexionBD->prepare($queryInsertDirigir);

                if ($stmtInsertDirigir) {
                    $stmtInsertDirigir->bind_param("ii", $NIA, $idAvisoInsertado);
                    $stmtInsertDirigir->execute();

                    // Verifica si la consulta fue exitosa
                    if ($stmtInsertDirigir->affected_rows === 0) {
                        $message_import = '<p>Error en la consulta: ' . $stmtInsertDirigir->error . '</p>';
                        $_SESSION['message_import'] = $message_import;
                        header("Location: publicar-aviso.php");
                        exit;
                    }

                    $stmtInsertDirigir->close();
                } else {
                    // Manejar error en la preparación de la consulta
                    $message_import = '<p>Error al preparar la consulta: ' . $conexionBD->error . '</p>';
                    $_SESSION['message_import'] = $message_import;
                    header("Location: publicar-aviso.php");
                    exit;
                }
            }
        } else {
            $message_import = '<p>Error formulario petición POST.</p>';
            $_SESSION['message_import'] = $message_import;
            header("Location: publicar-aviso.php");
            exit;
        }
    } else {
        $message_import = '<p>Error formulario petición POST.</p>';
        $_SESSION['message_import'] = $message_import;
        header("Location: publicar-aviso.php");
        exit;
    }
    
    include_once "inc/codigo_finalizacion.php";

    $message_import = '<p>Aviso registrado con exito!!</p>';
    $_SESSION['message_import'] = $message_import;
    header("Location: publicar-aviso.php");
    exit;
?>