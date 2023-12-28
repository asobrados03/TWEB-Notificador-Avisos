<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<?php
    $NIA = $_SESSION['NIA'];
    if($NIA>=100) {
        navEstudiante();
    } else {
        navProfesor();
    }
?>

<?php function navEstudiante() { ?>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">App Notificador TWeb</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./menu-estudiante.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./restablecer-contrasenia.php">Restablecer Contraseña</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./indice-avisos.php">Consultar Avisos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cerrar-sesion.php">Cerrar Sesión</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
<?php } ?>
<?php function navProfesor() { ?>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">App Notificador TWeb</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./menu-profesor.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./registrar-estudiante.php">Registrar Estudiante</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Avisos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./indice-avisos.php">Consultar Avisos</a></li>
                        <li><a class="dropdown-item" href="./publicar-aviso.php">Publicar Avisos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="./importar-aviso.php">Importar Avisos</a></li>
                        <li><a class="dropdown-item" href="./leer-aviso-importado.php">Leer Avisos Importados</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cerrar-sesion.php">Cerrar Sesión</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
<?php } ?>