<?php
    // Iniciar sesión
    session_start();
    
    $dir_upload = "../uploads/";
    $nom_fich_subido = $dir_upload . basename($_FILES["fichero_usuario"]["name"]);
    $uploadOk = 1;
    $tipoFicheroCsv = strtolower(pathinfo($nom_fich_subido, PATHINFO_EXTENSION));

    // Comprobar si el fichero ya existe (en el servidor)
    if (file_exists($nom_fich_subido)) {
        $message_import = '<p>Lo siento, el fichero ya existe.</p>';
        $uploadOk = 0;
        $_SESSION['message_import'] = $message_import;
        header('Location: importar-aviso.php');
        exit;
    }

    // Comprobar si el fichero es un archivo CSV
    $tipoMime = $_FILES["fichero_usuario"]["type"];
    if ($tipoMime !== 'text/csv' && $tipoMime !== 'application/vnd.ms-excel') {
        $message_import = '<p>Lo siento, solo se permiten ficheros CSV.</p>';
        $uploadOk = 0;
        $_SESSION['message_import'] = $message_import;
        header('Location: importar-aviso.php');
        exit;
    }

    // Comprobar el tamaño del archivo
    if ($_FILES["fichero_usuario"]["size"] > 500000) {
        $message_import = '<p>Lo siento, el archivo CSV es muy grande.</p>';
        $uploadOk = 0;
        $_SESSION['message_import'] = $message_import;
        header('Location: importar-aviso.php');
        exit;
    }

    if (($handle = fopen($_FILES["fichero_usuario"]["tmp_name"], "r")) !== FALSE) {
        // Leer la primera línea (encabezados) y especificar el delimitador manualmente
        $header = fgetcsv($handle, 1000, ";");
    
        // Verificar que la estructura del archivo sea correcta
        $expected_headers = array("NIA", "nombreEstudiante", "asunto", "contenido");
        if ($header !== $expected_headers) {
            $_SESSION['message_import'] = '<p>Lo siento, la estructura del archivo CSV no es válida.</p>';
            $uploadOk = 0;
            fclose($handle);
            header('Location: importar-aviso.php');
            exit;
        }
    
        fclose($handle);
    } else {
        $_SESSION['message_import'] = '<p>Lo siento, ha habido un error leyendo el archivo CSV.</p>';
        $uploadOk = 0;
        header('Location: importar-aviso.php');
        exit;
    }
    
    // Comprobar si ha habido algún error
    if ($uploadOk == 0) {
        $message_import = '<p> Tu fichero no se ha subido.</p>';
        $_SESSION['message_import'] = $message_import;
        header('Location: importar-aviso.php');
        exit;
    } else {
        if (move_uploaded_file($_FILES["fichero_usuario"]["tmp_name"], $nom_fich_subido)) {
            $message_import = '<p>Se ha subido el fichero ' . basename($_FILES["fichero_usuario"]["name"]) . '</p>';
            $_SESSION['message_import'] = $message_import;
            header('Location: importar-aviso.php');
            exit;
        } else {
            $message_import = '<p>Lo siento, ha habido un error subiendo el fichero.</p>';
            $_SESSION['message_import'] = $message_import;
            header('Location: importar-aviso.php');
            exit;
        }
    }
?>