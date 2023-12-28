<?php
	// Función para validar y sanitizar la entrada y prevenir ataques por inyección de código JavaScript y SQL
	function comprobar_entrada($conexion, $dato) {
		$dato = mysqli_real_escape_string($conexion, $dato);
		$dato = trim($dato);
		$dato = stripslashes($dato);
		$dato = htmlspecialchars($dato);
		return $dato;
	}

	function cabecera_nombre($conexionBD){
		$email=$NIA="";
		
		// Verificar si la variables de sesión estan definidas
		if (isset($_SESSION['email'], $_SESSION['NIA'])) {
			$email = $_SESSION['email'];
			$NIA = $_SESSION['NIA'];
		} else {
			header('Location: index.php');
			exit;
		}    

		if (isset($_SESSION['email'], $_SESSION['NIA'])) {
			$email = $_SESSION['email'];
			$NIA = $_SESSION['NIA'];
		
			// Preparar y ejecutar la consulta
			$sentenciaSQL = "SELECT Nombre FROM USUARIO WHERE Email = ? AND NIA = ?";
			$stmt = mysqli_prepare($conexionBD, $sentenciaSQL);
			mysqli_stmt_bind_param($stmt, "si", $email, $NIA);
			$resultado = mysqli_stmt_execute($stmt);
		
			if ($resultado) {
				mysqli_stmt_bind_result($stmt, $nombre);
				mysqli_stmt_fetch($stmt);
			} else {
				header('Location: index.php');
				exit; 
			}

			// Cerrar la sentencia preparada
			mysqli_stmt_close($stmt);
		}

		return $nombre;
	}

	function validarContrasena($contrasena) {
		// Verificar longitud mínima
		if (strlen($contrasena) < 6) {
			return false;
		}
	
		// Verificar si contiene al menos una letra mayúscula
		if (!preg_match('/[A-Z]/', $contrasena)) {
			return false;
		}
	
		// Verificar si contiene al menos una letra minúscula
		if (!preg_match('/[a-z]/', $contrasena)) {
			return false;
		}
	
		// Verificar si contiene al menos un número
		if (!preg_match('/[0-9]/', $contrasena)) {
			return false;
		}
	
		// La contraseña cumple con todos los criterios
		return true;
	}
?>