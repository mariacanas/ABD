<?php 
require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Form
{

	public function __construct(){
		parent::__construct('formLogin');
	}

	protected function generaCamposFormulario($datosIniciales){
		$nombreCorreo = $datos['email_usuario'] ?? '';
		$formulario = <<<EOF
		<h3> Introduce los datos para iniciar sesión </h3>
			<fieldset>
				<legend></legend>
				<div class="grupo-control">
					<label> E-mail </label> <input type="text" name="email_usuario" value="$nombreCorreo" />
				</div>
				<div class="grupo-control">
					<label> Contraseña </label> <input type="password" name="password" />
				</div>
				<div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
			</fieldset>
		EOF;
		return $formulario;
	}

	protected function procesaFormulario($datos){

		$ok = true;
		$email_usuario = $datos['email_usuario'];
		if (!$email_usuario)  {
		  
		  $ok = false;
		}
		$password = isset($datos['password']) ? $datos['password'] : null ;
		if ( !$password ) {
		  echo 'Usuario o contraseña incorrectos';
		  $ok = false;
		}
		if ( $ok ) {
			
			$usuario = Usuario::login($email_usuario, $password);
			
			if ( !$usuario) {		
				echo "El usuario o el password no coinciden";
			} 
			else {
				
			$_SESSION['login'] = true;
			$_SESSION['nombre'] = $usuario->getNombre(); 
			$_SESSION['password'] = $password;
			$_SESSION['apellido'] = $usuario->getApellido();
			$_SESSION['email_usuario'] = $email_usuario;
			$_SESSION['telefono'] = $usuario->getTelefono();
			$_SESSION['tipo_usuario'] = $usuario->getTipoUsuario();
			?><meta http-equiv="refresh" content="0; url=http://localhost/abd/index.php" /><?php	
			}
		}

	  }

	
}