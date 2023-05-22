


<?php
require_once __DIR__.'/includes/config.php';
	function mostrarContenido(){
	?>	
	<div class="contenido">
    <h1> Bienvenido a INFO-TEL </h1>

    <p>La función de INFO-TEL será de gestionar las llamadas recibidas, poder realizar 
		llamadas y tener una agenda de contactos online, siendo
    una forma ideal de mantener una visión general de tu comunicación. 
    Organice, gestione y visualice la información de sus contactos y de las llamadas
		que ha recibido.</p>
    
    <p> una vez te crees una cuenta podrás añadir,borrar,consultar y editar la información de los
		  los contactos que tengas, además de poder realizar llamadas y ver la información de ellas. </p>

	</div>
    <?php
	}



		
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

  	<title>InfoTel</title>
</head>
<body>
<div id="contenedor" class="contenedor">
	<?php
		
		require("includes/comun/cabecera.php");
		require("includes/comun/barraNav.php");
	?>
	
		<div>
				<?= mostrarContenido() ?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>

