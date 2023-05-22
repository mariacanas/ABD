

<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioVerContactos.php';
require_once __DIR__.'/includes/FormularioAñadirContacto.php';
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
  	<title>Mis Contactos</title>
</head>
<body>
<div class="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/barraNav.php");
		
	?>
	
		<div id="contenido" class="contenido">
			<?php 
			if(isset($_SESSION["login"])){
				?><a class="buscador" href="crearContacto.php">Añadir contacto</a> <?php
			$formVerContactos = new FormularioVerContactos(); 
			$formVerContactos->gestiona();
		
			}
			else{
				?>
				<h3 class="aviso">Debes iniciar sesion</h3>
				<?php
			}
			?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>