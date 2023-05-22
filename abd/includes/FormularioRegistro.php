
<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioRegistro extends Form{

	public function __construct(){
		parent::__construct('formRegistro');
	}

	
	protected function generaCamposFormulario($datosIniciales){
			$email_usuario = $datos['email'] ?? '';
			$nombre = $datos['nombre'] ?? '';
			$apellidos = $datos['apellidos'] ?? '';
			$telefono = $datos['telefono'] ?? '';
			$formulario = <<<EOF
			<h3> Introduce los datos para crear una cuenta </h3>
			<fieldset>
				<div class="grupo-control">
					<label> E-mail </label> <input class="control" type="text" name="email_usuario" value="$email_usuario"/>
				</div>
				<div class="grupo-control">
					<label> Nombre  </label> <input class="control" type="text" name="nombre" value="$nombre"/>
				</div>
				<div class="grupo-control">
					<label> Apellidos  </label> <input class="control" type="text" name="apellido" value="$apellidos"/>
				</div>
				<div class="grupo-control">
					<label> Telefono  </label> <input class="control" type="int" name="telefono" value="$telefono"/>
				</div>
				<div class="grupo-control">
					<label> Contraseña  </label> <input class="control" type="password" name="password" />
				</div>
				<div class="grupo-control">
					<label> Repite Contraseña  </label> <input class="control" type="password" name="password1" />
				</div>
				<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
				</fieldset>
		EOF;

		return $formulario;
	}


	protected function procesaFormulario($datos){

		$email_usuario = $datos['email_usuario'] ?? null;
		$error=false;
		if ( empty($email_usuario) || mb_strlen($email_usuario) < 5 ) {
		echo "El correo tiene que tener una longitud de al menos 10 caracteres";
		}

		$nombre = $datos['nombre'] ?? null;
		if ( empty($nombre) ) {
			echo "El campo de nombre no puede estar vacio";
			$error=true;
		}

		$apellido = $datos['apellido'] ?? null;
		if(empty($apellido)){
			echo "El campo de apellido no puede estar vacio";
			$error=true;
		}

		$telefono = $datos['telefono'] ?? null;
		if(empty($telefono)){
			echo "El campo de telefono no puede estar vacio";
			$error=true;
		}
		$password = $datos['password'] ?? null;
		if ( empty($password) || mb_strlen($password) < 5 ) {
			echo "El password tiene que tener una longitud de al menos 5 caracteres.";
			$error=true;
		}
		$password2 = $datos['password1'] ?? null;
		if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
			echo "Los passwords deben coincidir";
			$error=true;
		}

		if ($error === false) {
		/* BUSCAUSUARIO */
			$usuario = Usuario::crea(1,$email_usuario,$nombre,  $apellido, $password,$telefono);

			if(!$usuario){
				echo "El usuario ya existe";
				?><meta http-equiv="refresh" content="1; url=http://localhost/abd/registro.php" /><?php
			}
			else{
				Aplicacion::getInstancia()->login($usuario);
				?><meta http-equiv="refresh" content="0; url=http://localhost/abd/index.php" /><?php
			}
		}
		else{
			?><meta http-equiv="refresh" content="1; url=http://localhost/abd/registro.php" /><?php
		}
		
	}
}


?>