<?php
    include_once "inc/codigo_inicializacion.php";

    // Definir las variables e inicializarlas a vacío
    $email = $contrasenia = $nombre = "";

    // Comprobar la entrada del registro del usuario estudiante de la app
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["nombre"], $_POST["email"], $_POST["contrasena"])) {
            $nombre = comprobar_entrada($conexionBD, $_POST["nombre"]);
            $email = comprobar_entrada($conexionBD, $_POST["email"]);
            $contrasenia = comprobar_entrada($conexionBD, $_POST["contrasena"]);

            // Consulta preparada para evitar inyección de SQL
            $sentenciaSQL = "INSERT INTO USUARIO (Nombre, Email, Contrasenia) VALUES (?, ?, SHA2(?, 512))";
            $stmt = mysqli_prepare($conexionBD, $sentenciaSQL);
            
            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $contrasenia);

            // Ejecutar la consulta
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                // El usuario ha sido insertado correctamente, redireccionar a registrar estudiante
                $message_import = '<p>El estudiante ha sido registrado en la plataforma correctamente</p>';
                $_SESSION['message_import'] = $message_import;
                header("Location: registrar-estudiante.php");
                exit;
            } else {
                $message_import = '<p>Error al insertar el usuario en la base de datos.</p>';
                $_SESSION['message_import'] = $message_import;
                header("Location: registrar-estudiante.php");
                exit;
            }

            // Cerrar la consulta preparada
            mysqli_stmt_close($stmt);
        }

    } else {
        $message_import = '<p>Error en el formulario petición POST.</p>';
        $_SESSION['message_import'] = $message_import;
        header("Location: registrar-estudiante.php");
        exit;
    }

    include_once "inc/codigo_finalizacion.php";
?>
