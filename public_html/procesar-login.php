<?php
    include_once "inc/codigo_inicializacion.php";

    // Verificar si ya ha iniciado sesión
    if(isset($_SESSION['email'])) {
        // Redirigir al usuario a su zona privada
        $NIA = $_SESSION['NIA']; // Asegúrate de tener $_SESSION['NIA'] definida
        if($NIA >= 100) {
            header('Location: menu-estudiante.php');
            exit;
        } else {
            header('Location: menu-profesor.php');
            exit;
        }
    }

    // Definir las variables e inicializarlas a vacío
    $email = $contrasenia = "";

    // Comprobar la entrada del inicio de sesión de la app
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["usuario"], $_POST["contrasena"])) {
            if (empty($_POST["usuario"])) {
                $emailErr = '<p>El email es obligatorio.</p>';
                $_SESSION['emailErr'] = $emailErr;
                header('Location: index.php');
                exit;
            } else {
                $email = comprobar_entrada($conexionBD, $_POST["usuario"]);
                // comprueba si es una dirección de correo bien formada
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = '<p>Formato no válido de email.</p>';
                    $_SESSION['emailErr'] = $emailErr;
                    header('Location: index.php');
                    exit;
                }
            }

            if (empty($_POST["contrasena"])) { 
                $contraseniaErr = '<p>La contraseña es obligatoria.</p>';
                $_SESSION['contraseniaErr'] = $contraseniaErr;
                header('Location: index.php');
                exit;
            } else {
                $contrasenia = comprobar_entrada($conexionBD, $_POST["contrasena"]);
                if (!validarContrasena($contrasenia)) {
                    $contraseniaErr = '<p>La contraseña no cumple con los requisitos de seguridad.</p>';
                    $_SESSION['contraseniaErr'] = $contraseniaErr;
                    header('Location: index.php');
                    exit;
                }
            }

            // Consulta preparada para evitar inyección de SQL
            $sentenciaSQL = "SELECT NIA FROM USUARIO WHERE Email = ? AND Contrasenia = SHA2(?, 512)";
            $stmt = mysqli_prepare($conexionBD, $sentenciaSQL);

            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "ss", $email, $contrasenia);

            // Ejecutar la consulta
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                // Obtener resultados
                $resultado = mysqli_stmt_get_result($stmt);

                if ($resultado->num_rows > 0) {
                    // El usuario existe
                    $fila = mysqli_fetch_assoc($resultado);
                    $NIA = $fila['NIA'];

                    // Almacenar datos en la sesión
                    $_SESSION['email'] = $email;
                    $_SESSION['NIA'] = $NIA;

                    mysqli_stmt_close($stmt); // Cerrar la consulta preparada

                    // Redireccionar según el tipo de usuario
                    $urlDestino = ($NIA >= 100) ? 'menu-estudiante.php' : 'menu-profesor.php';

                    header("Location: $urlDestino");
                    exit;
                }
            } else {
                $message_import = '<p>Error al ejecutar la consulta preparada.</p>';
                $_SESSION['message_import'] = $message_import;
                mysqli_stmt_close($stmt); // Cerrar la consulta preparada
                header("Location: index.php");
                exit;
            }
        }

    } else {
        $message_import = '<p>Error formulario petición POST.</p>';
        $_SESSION['message_import'] = $message_import;
        header("Location: index.php");
        exit;
    }

    // Si llegamos aquí, el usuario no existe, redirige al usuario a la pantalla de inicio de sesión
    header('Location: index.php');
    exit;

    include_once "inc/codigo_finalizacion.php";
?>
