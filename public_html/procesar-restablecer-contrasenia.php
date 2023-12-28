<?php
    include_once "inc/codigo_inicializacion.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["nueva_contrasena"], $_POST["confirmar_contrasena"])) {
            $nueva_contrasena = comprobar_entrada($conexionBD, $_POST["nueva_contrasena"]);
            $confirmar_contrasena = comprobar_entrada($conexionBD, $_POST["confirmar_contrasena"]);

            if ($nueva_contrasena == $confirmar_contrasena) {
                // Actualizar la contraseña en la base de datos
                $sentenciaSQL = "UPDATE USUARIO SET Contrasenia=SHA2('$confirmar_contrasena', 512) WHERE NIA=$NIA;";
                $result = mysqli_query($conexionBD, $sentenciaSQL);

                if ($result) {
                    $message_import = '<p>Contraseña restablecida con éxito.</p>';
                    $_SESSION['message_import'] = $message_import;
                    header('Location: restablecer-contrasenia.php');
                    exit;
                } else {
                    $message_import = '<p>Error al restablecer la contraseña:' . mysqli_error($conexionBD) . '</p>';
                    $_SESSION['message_import'] = $message_import;
                    header('Location: restablecer-contrasenia.php');
                    exit;
                }
            } else {
                $message_import = '<p>Las contraseñas no coinciden. Vuelve a intentarlo.</p>';
                $_SESSION['message_import'] = $message_import;
                header('Location: restablecer-contrasenia.php');
                exit;
            }
        }
    }

    include_once "inc/codigo_finalizacion.php";
?>
