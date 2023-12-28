<?php
	// Registrar la función cerrarConexionBD() para que se ejecute al finalizar el script
	register_shutdown_function('cerrarConexionBD');

	// Función para cerrar la conexión con la base de datos
	function cerrarConexionBD() {
		global $conexionBD;
		
		// Cerrar la conexión con la base de datos
		mysqli_close($conexionBD);
		
		ob_end_flush(); //Configuración procesador PHP: volcar la SALIDA de PHP y deshabilita el buffering
	}
?>