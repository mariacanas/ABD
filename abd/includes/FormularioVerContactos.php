



<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioVerContactos extends Form{

	

	public function __construct(){
		parent::__construct('formVerContacto');
	}


	protected function generaCamposFormulario($datosIniciales){
			
       
        $telefono = $datos['telefono'] ?? '';
        $formulario = <<<EOF
        <fieldset>
            
            <div class="buscador-contactos">
                Contacto a buscar  <input class="control" type="text" name="telefono" placeholder="Telefono" minlength="9" maxlength="9"/>
               <button type="submit" name="verinformacion">Buscar</button>
            </div>
        </fieldset>
        EOF;

        $contactos = Usuario::mostrarContactos($_SESSION['email_usuario']);

        $formulario .= $contactos;

    return $formulario;
}


protected function procesaFormulario($datos){

    $contac = Usuario::buscarContacto($_SESSION['email_usuario'],$datos['telefono']);

    if($contac!=false){

       echo Usuario::muestrainformacionContacto($contac[1],$contac[2],$contac[3]);

    }
    else{
        echo "<p>No tienes ese contacto en la agenda</p>";
    }
    echo "<p><a href='./verContacto.php'> Ver mis Contactos </a></p>";
}
}

?>