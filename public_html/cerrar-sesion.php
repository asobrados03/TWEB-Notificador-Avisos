<?php
    session_start(); // Inicia la sesión

    // Restablece y destruye todas las variables de sesión
    session_unset();
    session_destroy();

    // Establece el tiempo de vida de la cookie de sesión a cero (para borrar la cookie en el lado del cliente)
    setcookie(session_name(), '', time() - 3600, '/');


    // Redirige a la página de inicio de sesión o a donde desees después de cerrar sesión
    header('Location: index.php');
    exit();
?>
