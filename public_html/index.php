<?php
   // Verificar si ya ha iniciado sesión
    session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Plataforma de Avisos</title>
    <link rel="stylesheet" href="css/estilo.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="inicio ajustar">
    <div class="d-flex flex-column align-items-center justify-content-center vh-100">
        <h1 class="display-4" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); color: #fff;">PLATAFORMA DE AVISOS</h1>
        <div class="container cuerpo">
            <h2 class="h4" style="background-color: rgba(255, 255, 255, 0.5);">Iniciar Sesión</h2>
            <p><span class="text-danger" style="background-color: rgba(255, 255, 255, 0.5);">* campo obligatorio.</span></p>
            <form action="procesar-login.php" method="POST" onsubmit="return validarFormularioInicioSesion()">
                <div class="form-group" style="background-color: rgba(255, 255, 255, 0.5);">
                    <label for="usuario">Usuario <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required title="Por favor, ingrese su correo electronico">
                    <span id="mensajeEmail" class="text-danger"><?php  // Recuperar el mensaje de la sesión
                            $mensajeEmail = isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : '';
                            // Mostrar el mensaje
                            echo $mensajeEmail;
                            // Limpiar el mensaje después de mostrarlo
                            unset($_SESSION['emailErr']); ?> 
                    </span>
                </div>
                <div class="form-group" style="background-color: rgba(255, 255, 255, 0.5);">
                    <label for="contrasena">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" minlength="6" maxlength="12" required title="Por favor, ingrese su contraseña">
                    <span id="mensajeContrasenia" class="text-danger"><?php  // Recuperar el mensaje de la sesión
                                $mensajeContrasenia = isset($_SESSION['contraseniaErr']) ? $_SESSION['contraseniaErr'] : '';
                                // Mostrar el mensaje
                                echo $mensajeContrasenia;
                                // Limpiar el mensaje después de mostrarlo
                                unset($_SESSION['contraseniaErr']); ?> 
                    </span>
                </div>
                <div class="d-flex justify-content-center">
                    <button style="margin-top: 10px;" type="submit" class="btn btn-primary" name="submit" value="Submit">Iniciar Sesión</button>
                </div>
            </form>
            <?php
                // Recuperar el mensaje de la sesión
                $mensaje = isset($_SESSION['message_import']) ? $_SESSION['message_import'] : '';

                // Mostrar el mensaje
                echo $mensaje;

                // Limpiar el mensaje después de mostrarlo
                unset($_SESSION['message_import']);
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/comportamientoLadoCliente.js"></script>
</body>
</html>