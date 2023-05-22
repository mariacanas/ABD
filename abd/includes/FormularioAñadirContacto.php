


<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioAñadirContacto extends Form{


	public function __construct(){
		parent::__construct('formAñadirContacto');
       
	}

	
	protected  function generaCamposFormulario($datosIniciales){

        $formulario = <<<EOF
        <fieldset>
            <div>
                <label> Nombre  </label> <input class="control" type="text" placeholder="Nombre" name="nombre" />
            </div>
            <div >
                <label> Apellido  </label> <input class="control" type="text" name="apellido"  placeholder="Apellidos"/>
            </div>
            <div >
                <label> Telefono  </label> <input class="control" type="text" name="telefono" placeholder="Num de telefono" />
            </div>

            <div><button type="submit" name="crearContacto"> Añadir contacto </button></div>
            </fieldset>
    EOF;

    
    return $formulario;
}


	protected function procesaFormulario($datos){
       $correcto = true;
		$nombre = $datos['nombre'] ?? null;
		if ( empty($nombre) ) {
			echo"El campo de nombre no puede estar vacio";
            $correcto = false;
		}

        if($correcto){

            $apellido = $datos['apellido'] ?? null;
            if(empty($apellido)){
                echo "El campo de apellido no puede estar vacio";
                $correcto = false;
            }
        }

        if($correcto){

            $telefono = $datos['telefono'] ?? null;
            if (empty($telefono) || mb_strlen($telefono) != 9) {
                echo " El campo del telefono tiene que tener 9 números";
                $correcto = false;
            }
        }
        
        if($correcto){
            $existeContacto = Usuario::buscarContacto($_SESSION['email_usuario'],$telefono);
        
            if (!$existeContacto) {
            
                Usuario::insertaContacto($nombre, $apellido,$telefono,$_SESSION['email_usuario']);
                echo "<p>Contacto insertado en tu agenda</p>";
            }
            else{
                echo "Ya tienes un contacto en la agenda con ese número";
            }
        }
        echo "<p><a href='./verContacto.php'> Ver mis Contactos </a></p>";
		
	}

   
}


?>