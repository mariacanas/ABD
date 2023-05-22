


<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';
$app->logout();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
  	<title>Logout</title>
</head>
<body>
<div id="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/barraNav.php");
	?>
	
		<div id="contenido">
			<h3 class="aviso">Hasta Pronto</h3>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>