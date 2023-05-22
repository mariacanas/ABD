<?php

function mostrarSaludo() {
	
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "<a href='editarUsuario.php'>Ver Perfil</a> <a href='logout.php'> Cerrar Sesión </a>";
		
	} else {
		echo " <a href='login.php'> Login </a> <a href='registro.php'>  Registro </a>";
	}
}
?>
<header>
	<div class="contenidoCabecera">
		<img class="imagenLogo" src="imagenes/logo.png" alt="Logo Página">
		<div class="saludo">
		<?php
			mostrarSaludo();
		?>
		</div>
	</div>
</header>