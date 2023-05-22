


<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioEditarDatos extends Form{

	public function __construct(){
		parent::__construct('formEditarDatos');
	}

	
	protected function generaCamposFormulario($datosIniciales){
       
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';

        echo $nombre;
        echo $apellido;

        $formulario = <<<EOF
        <fieldset>
            <div class="grupo-control">
                <label> Nombre : </label> <input class="control" type="text" name="nombre" value="$nombre" placeholder = "$_SESSION[nombre]"/>
            </div>
            <div class="grupo-control">
                <label> Apellido : </label> <input class="control" type="text" name="apellido" value="$apellido" placeholder = "$_SESSION[apellido]"/>
            </div>
            <div class="grupo-control">
            <label> Telefono  </label> <input class="control" type="int" name="telefono" readonly="readonly" placeholder = "$_SESSION[telefono]"/>
            </div>
            <div class="grupo-control">
            <label> Email  </label> <input class="control" type="text" name="email" readonly="readonly" placeholder = "$_SESSION[email_usuario]"/>
            </div>
            <div class="grupo-control">
                <label> Contraseña (Antigua): </label> <input class="control" type="password" name="password"/>
            </div>

            <div class="grupo-control">
                <label> Contraseña (Nueva): </label> <input class="control" type="password" name="password1"/>
            </div>

            <div class="grupo-control"><button type="submit" name="registro">Editar Datos</button></div>
            </fieldset>
    EOF;

    return $formulario;
}


public function procesaFormulario($datos){
   $resultado = array();
   
   
    $nombre = $datos['nombre'] ?? null;
    if ( empty($nombre) ) {
        $nombre = $_SESSION['nombre'];
    }

    $apellido = $datos['apellido'] ?? null;
    if(empty($apellido)){
        $apellido = $_SESSION['apellido'];
    }

    $password = $datos['password'] ?? null;
    if (empty($password)) {
        $password = $_SESSION['password'];

    }
    else{
        $password1 = $datos['password1'] ?? null;
        if ( empty($password1)) {
            $password = $_SESSION['password'];
        }
        else{
            if($password == $_SESSION['password']){
                $password=$password1;
            }
            else{
                echo "Error, la contraseña antigua no coincide con la introducida";
                return false;
            }
        }
    }
    return Usuario::actualiza($_SESSION['email_usuario'],$nombre, $apellido,$password);

}
}