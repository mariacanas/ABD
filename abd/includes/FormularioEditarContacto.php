


<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioEditarContacto{
	
	public static function generaCamposFormulario($telefono,$nombrea,$apellidoa){
    
        
            $formulario = <<<EOF
            <form action="#" method="post">
            
                <div class="grupo-control">
                    <label> Nombre  </label> <input class="control" type="text" name="nombre" placeholder = '$nombrea' />

                </div>
                <div class="grupo-control">
                    <label> Apellido  </label> <input class="control" type="text" name="apellido"  placeholder = "$apellidoa"/>

                </div>
                <div class="grupo-control">
                <label> Telefono  </label> <input class="control" type="text" name="telefono" readonly="readonly" placeholder = "$telefono"/>

            </div>

                <div class="grupo-control">
                    <button type="submit" name="editar" >Editar Contacto</button>
                    <button type="submit" name="eliminar" >Eliminar Contacto</button>
                </div>
                </form>
        EOF;

        echo $formulario;

        
       if(isset($_POST["editar"])){

            $nombre = $_POST['nombre'];
            if (empty($nombre) ) {
                $nombre = $nombrea;
            }

            $apellido = $_POST['apellido'];
            if(empty($apellido)){
                $apellido = $apellidoa;
            }

        return Usuario::actualizaContacto($_SESSION['email_usuario'],$nombre, $apellido,$telefono);

       }
       if(isset($_POST['eliminar'])){
        return Usuario::eliminarContacto($_SESSION['email_usuario'],$telefono);
       }
        
    }
}


