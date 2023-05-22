
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<?php
require_once __DIR__.'/aplicacion.php';
require_once __DIR__.'/FormularioEditarContacto.php';

class Usuario{


    private $tipo_usuario;
    private $email_usuario;
    private $nombre;
    private $apellidos;
    private $password;
    private $telefono;

    public function __construct($tipo_usuario,$email_usuario,$nombre,$apellidos,$password,$telefono){
        $this->tipo_usuario = $tipo_usuario;
        $this->email_usuario = $email_usuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->telefono = $telefono;
    }
    
    public static function buscaTelefono($telefono){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $query = ("SELECT telefono FROM usuarios WHERE telefono = '$telefono'");
        $rs = $conn->query($query);
    
        $result = false;
        if($rs->num_rows==1) {
           $result = true;
        }
        return $result;
    }

    public static function buscaCorreo($email_usuario){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        
        $query = sprintf("SELECT * FROM usuarios WHERE email_usuario = '$email_usuario'");
        $rs = $conn->query($query);
        $result = false;
        if ($rs){
            if ($rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['id_tipo'],$fila['email_usuario'],  $fila['nombre'], $fila['apellidos'], $fila['password'],$fila['telefono']);
                $rs->free();
                return $user;
            }    
        }
        return false;
    }

    public static function login($email_usuario, $password){
       
        $usuario = self::buscaCorreo($email_usuario);
        
        if($usuario && $usuario->compruebaPassword($password)) { 
            return $usuario;
        }
        return false;
    }

    public function compruebaPassword($password){
        if($password === $this->password){
            return true;
        }
        return false;
    }


    public  static function actualiza($email,$nombre,$apellido, $password){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuarios set nombre='$nombre', apellidos='$apellido', password='$password' where email_usuario='$email'");
        
        if($conn->query($query)){
            echo "Datos actualizados";

            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['password'] = $password;
        }
        else{
            echo "Error al actualizar los datos";
        }
    }

    public static function crea($tipo_usuario,$email_usuario, $nombre, $apellido, $password,$telefono){
        
        $email_u = self::buscaCorreo($email_usuario);
        $tel = self::buscaTelefono($telefono);

        if($email_u || $tel) {
            return false;
        }
         
        $user = new Usuario($tipo_usuario,$email_usuario,$nombre, $apellido,$password,$telefono);
        return self::inserta($user);
    }

    private static function inserta($usuario){

        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuarios(id_tipo,email_usuario,nombre,apellidos,password,telefono) VALUES(1,'%s','%s', '%s','%s','%s')"
            , $conn->real_escape_string($usuario->email_usuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellidos)
            , $conn->real_escape_string ($usuario->password)
            , $conn->real_escape_string ($usuario->telefono));
        $conn->query($query);
        
        return $usuario;
    }

    public function getNombre(){
        return $this->nombre;
    }

	public function getApellido(){
        return $this->apellidos;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email_usuario;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }

    public static function muestrainformacionContacto($nombre,$apellido,$telefono){

        $con = "";
        $con .= "<table>";
        $con .= "<tr>";
        $con .= "<th> Nombre  </th>";
        $con .= "<th> Apellidos  </th>";
        $con .= "<th> Telefono </th>";
        $con .= "<th> Editar </th>";
        $con .= "</tr>";
        $con .= "<tr>";
        $con .= "<td>" .$nombre . ' ' ."</td>";
        $con .= "<td>" .$apellido . ' ' ."</td>";
        $con .= "<td>" .$telefono . ' ' ."</td>";
        $con .= "<td>" . "<a href='verContacto.php?tel=$telefono&nombre=$nombre&apellido=$apellido'><svg xmlns='http://www.w3.org/2000/svg' width='21' height='21' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
        <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'/>
            </svg></a>" . ' ' ."</td>";
       $con .= "</tr>";
       $con .= "</table>";
       $con .= '<br>';

        return $con;
    }

    public static function verUsuariosPagina(){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $con = "<h3> Usuarios de la página web </h3>";


        $con .= "<table>";
               
        $con .= "<tr>";
        $con .= "<th> Email Usuario  </th>";
        $con .= "<th> Nombre  </th>";
        $con .= "<th> Apellidos  </th>";
        $con .= "<th> Teléfono </th>";
        $con .= "<th> Contraseña </th>";
        $con .= "</tr>";
        
        $query= "SELECT * FROM usuarios  where id_tipo != 0 order by email_usuario ASC";
        $rs = $conn->query($query);

        if($rs->num_rows > 0){

            while($fila = $rs->fetch_assoc()){
                $con .= "<tr>";
                $con .= "<td>" .$fila['email_usuario'] . ' ' ."</td>";
                $con .= "<td>" .$fila['nombre'] . ' ' ."</td>";
                $con .= "<td>" .$fila['apellidos'] . ' ' ."</td>";
                $con .= "<td>" .$fila['telefono'] . ' ' ."</td>";
                $con .= "<td>" .$fila['password'] . ' ' ."</td>";
                $con .= "</tr>";
            }
        }
        else{
            $con = "No tienes usuarios en tu página web. ";
        }
        $con .= "</table>";
        return $con;
    }

    public static function buscarContacto($email,$telefono){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query = ("SELECT * FROM contactos WHERE email_usuario = '$email' and telefono ='$telefono'");
        $rs = $conn->query($query);

        
        if($rs){
           $file = $rs->fetch_row();
           return $file;  
        }
        return false;
    }

    public static function mostrarContactos($email){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $con = null;

        if(self::buscaCorreo($email)){
            $con .= "<table>"; 
            $con .= "<tr>";
            $con .= "<th> Nombre  </th>";
            $con .= "<th> Apellidos  </th>";
            $con .= "<th> Teléfono </th>";
            $con .= "<th> Editar </th>";
            $con .= "</tr>";
           
            $query= "SELECT * FROM contactos WHERE email_usuario = '$email' order by nombre ASC";
            $rs = $conn->query($query);

            if($rs->num_rows > 0){

                while($fila = $rs->fetch_assoc()){
                    $con .= "<tr>";
                    $con .= "<td>" .$fila['nombre'] . ' ' ."</td>";
                    $con .= "<td>" .$fila['apellido'] . ' ' ."</td>";
                    $con .= "<td>" .$fila['telefono'] . ' ' ."</td>";
                    $tel = $fila['telefono'];
                    $nom = $fila['nombre'];
                    $ape = $fila['apellido'];
                    $con .= "<td>" . "<a href='verContacto.php?tel=$tel&nombre=$nom&apellido=$ape'><svg xmlns='http://www.w3.org/2000/svg' width='21' height='21' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                     <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'/>
                         </svg></a>" . ' ' ."</td>";
                    $con .= "</tr>";
                }
            }
            else{
                $con = "No tienes contactos en tu agenda ";
            }
            $con .= "</table>";

            if(isset($_GET['tel'])){
                FormularioEditarContacto::generaCamposFormulario($_GET['tel'],$_GET['nombre'],$_GET['apellido']);
            }
        }
       else{
           $con = "Error al mostrar el contacto";
        }
       return $con;
    }


    public  static function actualizaContacto($email_usuario, $nombre,$apellido, $telefono){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        
        $query="UPDATE contactos  set nombre = '$nombre', apellido = '$apellido' where telefono = '$telefono' and email_usuario = '$email_usuario'";
        
        if($conn->query($query)){
            echo "Datos actualizados";
            ?><meta http-equiv="refresh" content="0.5; url=http://localhost/abd/verContacto.php" /><?php
        }
        else{
            echo "Error al actualizar los datos";
        }
        
    }

    public  static function eliminarContacto($email_usuario,$telefono){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
       
        $query= "DELETE FROM contactos WHERE telefono= '$telefono' AND email_usuario = '$email_usuario'";
        $conn->query($query);
        echo "Contacto eliminado";
        ?><meta http-equiv="refresh" content="0.5; url=http://localhost/abd/verContacto.php" /><?php 
    }

    public static function insertaContacto($nombre,$apellidos,$telefono,$email){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
            
        $query="INSERT INTO contactos (email_usuario, nombre,apellido,telefono) VALUES ('$email','$nombre','$apellidos','$telefono')";
        $conn->query($query);
       
    }
      
    public  static function verHistorialLLamadasContacto($email){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $con = "";

        if(self::buscaCorreo($email)){
            $con .= "<h3> Este es tu historial de llamadas realizadas </h3>";
            $con .= "<table>";
				
	    	$con .= "<tr>";
			$con .= "<th> Telefono  </th>";
			$con .= "<th> Fecha </th>";
			$con .= "<th> Hora </th>";
            $con .= "<th> Duración (minutos) </th>";
			$con .= "</tr>";
            
            $query= "SELECT * FROM historial WHERE email_usuario = '$email' order by fecha ASC";
            $rs = $conn->query($query);

            if($rs->num_rows > 0){

                while($fila = $rs->fetch_assoc()){
                    $con .= "<tr>";
                    $con .= "<td>" .$fila['telefono_contacto'] . ' ' ."</td>";
                    $con .= "<td>" .$fila['fecha'] . ' ' ."</td>";
                    $con .= "<td>" .$fila['hora'] . ' ' ."</td>";
                    $con .= "<td>" .$fila['duracion'] . ' ' ."</td>";
                    $con .= "</tr>";
                    $con .= '<br>';
                }
            }
            else{
                $con = "No tienes llamadas en tu historial ";
            }
            $con .= "</table>";
        }
        return $con;
    }


    public  static function realizarLLamada($email_usuario,$telefono){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
       
        $fecha = date("Y-m-d", mt_rand(0, 500000000));
        $hora = sprintf("%02d:%02d:%02d", rand(0, 23), rand(0, 59), rand(0, 59));

        $minutos = rand(0, 59);
        $segundos = rand(0, 59);
        $duracion = sprintf("%02d:%02d", $minutos, $segundos);

        $query="INSERT INTO historial (email_usuario, telefono_contacto,fecha,hora,duracion) 
            VALUES ('$email_usuario','$telefono','$fecha','$hora','$duracion')";
        $conn->query($query);
    }

}
?>