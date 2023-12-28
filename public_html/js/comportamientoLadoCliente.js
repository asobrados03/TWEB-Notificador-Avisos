function validarFormularioInicioSesion() {
	var usuario = document.getElementById('usuario').value;
	var contrasena = document.getElementById('contrasena').value;
	var mensajeEmail = document.getElementById('mensajeEmail');
	var mensajeContrasenia = document.getElementById('mensajeContrasenia');

	// Restablecer mensajes de error
	mensajeEmail.innerHTML = "";
	mensajeContrasenia.innerHTML = "";

	// Validar el campo de usuario
	if (usuario.trim() === "") {
		mensajeEmail.innerHTML = "Por favor, ingrese su correo electrónico.";
		return false;
	}

	// Validar el campo de contraseña
	if (contrasena.trim() === "") {
		mensajeContrasenia.innerHTML = "Por favor, ingrese su contraseña.";
		return false;
	}

	return true;
}

function validarFormularioImportar() {
	var fileInput = document.getElementById('fichero_usuario');
	var fileName = fileInput.value;
	var allowedExtensions = /(\.csv)$/i;

	if (!allowedExtensions.exec(fileName)) {
		alert('Por favor, carga un archivo con extensión .csv.');
		return false;
	}

	var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
	if (!dateRegex.test(columns[2])) {
		alert('La fecha en la tercera columna no tiene el formato correcto (YYYY-MM-DD).');
		return false;
	}

	var maxNameLength = 25;
	if (columns[1].length > maxNameLength) {
		alert('El nombre del estudiante no puede tener más de ' + maxNameLength + ' caracteres.');
		return false;
	}

	var maxSubjectLength = 60;
	if (columns[0].length > maxSubjectLength) {
		alert('El asunto no puede tener más de ' + maxSubjectLength + ' caracteres.');
		return false;
	}

	var maxContentLength = 150;
	if (columns[3].length > maxContentLength) {
		alert('El contenido no puede tener más de ' + maxContentLength + ' caracteres.');
		return false;
	}

	return true;
}

// Validar la estructutura del csv a importar
$(document).ready(function () {
    // Agregar evento de clic al botón de envío
    $('#importacion').on('click', function () {
        // Obtener el archivo seleccionado
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];

        // Verificar si se seleccionó un archivo
        if (file) {
            // Leer el contenido del archivo
            var reader = new FileReader();
            reader.onload = function (e) {
                // Verificar la estructura del archivo
                if (!validateCSVStructure(e.target.result)) {
                    alert('El archivo no tiene la estructura esperada.');
                }
            };
            reader.readAsText(file);
        } else {
            alert('Selecciona un archivo CSV.');
        }
    });

    // Función para validar la estructura del archivo CSV
    function validateCSVStructure(csvContent) {
        // Dividir el contenido del CSV en líneas
        var lines = csvContent.split('\n');

        // Obtener la primera línea (encabezados)
        var headers = lines[0].trim().split(';');

        // Verificar si los encabezados coinciden con los esperados
        var expectedHeaders = ["Profesor", "nombreEstudiante", "Titulo", "Contenido"];
        return JSON.stringify(headers) === JSON.stringify(expectedHeaders);
    }
});

function validarFormularioRE() {
    // Obtener valores de los campos
    var nombre = document.getElementById("nombre").value;
    var email = document.getElementById("email").value;
    var contrasena = document.getElementById("contrasena").value;

    // Validar que el nombre no esté vacío
    if (nombre.trim() === "") {
        alert("Por favor, ingrese el nombre del estudiante.");
        return false;
    }

    // Validar que el correo electrónico no esté vacío
    if (email.trim() === "") {
        alert("Por favor, ingrese el correo electrónico del estudiante.");
        return false;
    }

    // Validar el formato del correo electrónico
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Por favor, ingrese un correo electrónico válido.");
        return false;
    }

    // Validar que la contraseña no esté vacía
    if (contrasena.trim() === "") {
        alert("Por favor, ingrese la contraseña del estudiante.");
        return false;
    }

    // Validar la longitud de la contraseña
    if (contrasena.length < 6 || contrasena.length > 12) {
        alert("La contraseña debe tener entre 6 y 12 caracteres.");
        return false;
    }

    // Puedes agregar más validaciones según tus requisitos

    // Si todas las validaciones pasan, permite el envío del formulario
    return true;
}


function validarFormularioRC() {
    // Obtener valores de los campos
    var nuevaContrasena = document.getElementById('nueva_contrasena').value;
    var confirmarContrasena = document.getElementById('confirmar_contrasena').value;

    // Validar que la nueva contraseña y la confirmación sean iguales
    if (nuevaContrasena !== confirmarContrasena) {
        alert('Las contraseñas no coinciden. Por favor, inténtalo de nuevo.');
        return false;
    }

    // Validar longitud de la nueva contraseña
    if (nuevaContrasena.length < 6 || nuevaContrasena.length > 12) {
        alert('La nueva contraseña debe tener entre 6 y 12 caracteres.');
        return false;
    }

    // Validar que la nueva contraseña contenga al menos un número
    if (!/\d/.test(nuevaContrasena)) {
        alert('La nueva contraseña debe contener al menos un número.');
        return false;
    }

    // Validar que la nueva contraseña contenga al menos una letra mayúscula
    if (!/[A-Z]/.test(nuevaContrasena)) {
        alert('La nueva contraseña debe contener al menos una letra mayúscula.');
        return false;
    }

    // Resto de las validaciones según tus requisitos

    return true; // Si todas las validaciones pasan, envía el formulario
}

function validarFormularioPA() {
    // Obtener valores de los campos
    var titulo = document.getElementById("Titulo").value;
    var contenido = document.getElementById("Contenido").value;
    var destinatario = document.getElementById("Destinatario").value;

    // Validar que el título no esté vacío
    if (titulo.trim() === "") {
        alert("Por favor, ingrese el título del aviso.");
        return false;
    }

    // Validar la longitud máxima del título
    if (titulo.length > 50) {
        alert("El título del aviso no puede tener más de 50 caracteres.");
        return false;
    }

    // Validar el formato del título (puedes ajustar según tus necesidades)
    var formatoTitulo = /^[a-zA-Z0-9\s]+$/;
    if (!formatoTitulo.test(titulo)) {
        alert("El título del aviso debe contener solo letras, números y espacios.");
        return false;
    }

    // Validar que el contenido no esté vacío
    if (contenido.trim() === "") {
        alert("Por favor, ingrese el contenido del aviso.");
        return false;
    }

    // Validar la longitud máxima del contenido
    if (contenido.length > 150) {
        alert("El contenido del aviso no puede tener más de 150 caracteres.");
        return false;
    }

    // Validar que se haya seleccionado al menos un destinatario
    if (destinatario.length === 0) {
        alert("Por favor, seleccione al menos un destinatario.");
        return false;
    }

    // Si todas las validaciones pasan, permite el envío del formulario
    return true;
}

// Función para gestionar el botón de atrás cuando visualizas un aviso
var botonAtrasAviso = document.getElementById("botonAtrasAviso");

if (botonAtrasAviso !== undefined && botonAtrasAviso !== null) {
  // Ahora sabemos que botonAtrasAviso está definido y no es nulo, podemos proceder con el event listener.
  botonAtrasAviso.addEventListener("click", function() {
    window.location.href = "indice-avisos.php";
  });
}

// Función para manejar el filtro de los avisos del índice
$(document).ready(function () {
    // Manejar el cambio en el filtro
    $('#filtro-leido').change(function () {
        // Obtener el valor seleccionado
        var filtro = $(this).val();
        console.log('Filtro seleccionado:', filtro);

        // Realizar la solicitud AJAX
        $.ajax({
            type: 'POST',
            url: '../inc/filtrar-avisos.php',
            data: { filtro: filtro },
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                // Actualizar la lista de avisos en la interfaz de usuario
                $('#lista-avisos').html(data);
            },
            error: function () {
                alert('Error al cargar los avisos.');
            }
        });
    });
});