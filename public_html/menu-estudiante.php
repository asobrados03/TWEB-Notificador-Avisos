<?php include_once "inc/codigo_inicializacion.php"; ?>

<?php define("TITULO_PAGINA", "Menu Estudiante - Plataforma de Avisos");?>

<?php $nombre = cabecera_nombre($conexionBD);?>
<?php cabeceraPlantilla($nombre);?>

<div class="d-flex justify-content-center align-items-center" style="height: 15vh;">
    <h1 class="display-3"><?php echo "Bienvenido/a "; echo  $nombre;?></h1>
</div>

<?php piePlantilla();?>
<?php include_once "inc/codigo_finalizacion.php"; ?>