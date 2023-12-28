<?php
	// Iniciar sesión
    session_start();

	// Aquí se escribiría el código que se ejecutará al INICIO de cada script en PHP (código de inicialización)
    ob_start(); //Configuración procesador PHP: activa almacenamiento en buffer de la SALIDA de PHP
	
	//conexión con base de datos
	include_once "../conexionBD/conexion_BD.php";
	
	// Conectar con el servidor de bases de datos. Atención! la conexión es local
	$conexionBD = mysqli_connect($host, $usuario, $password, $bd, $puerto);

	if(is_null($conexionBD)){
		die("No se pudo conectar a la base de datos");
	}
	
	// Se incluye el código de la plantilla y de las funciones ...
	include "inc/codigo_funciones.php";
	include "inc/plantilla.php";

	// Elimina el contenido del búfer de salida y detiene la acumulación.
	ob_end_clean();
?>
