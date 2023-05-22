
<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioRealizarLLamada extends Form{

	public function __construct(){
		parent::__construct('formRealizarLLamada');
	}

	protected function generaCamposFormulario($datosIniciales){
			
       
        $telefono = $datos['telefono'] ?? '';

        $formulario = <<<EOF
        <fieldset>
            
            <p> Número de Telefono de tus contactos al que quieres realizar la llamada </p> 
            <div>  
                <input class="control" type="text" name="telefono" placeholder="Número" />
                <button type="submit" name="realizarllamada"> LLamar </button>
            </div>
        </fieldset>
    EOF;

    return $formulario;
}

    protected function procesaFormulario($datos){

        $telefono = $datos['telefono'] ?? null;
        $existeContacto = Usuario::buscarContacto($_SESSION['email_usuario'],$telefono);

        if($existeContacto){
            Usuario::realizarLLamada($_SESSION['email_usuario'],$telefono);
        }
        else{
            echo "<p> No tienes ese contacto en la agenda </p>";
        }
        ?><meta http-equiv="refresh" content="0; url=http://localhost/abd/historialLLamadas.php" /><?php	
        
    }

}
?>