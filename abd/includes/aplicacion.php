
<?php

class Aplicacion{
    private $inicializada = false;
    private static $instancia;
    private $conn;

    //Crea instancia e inicializa la BD
    public static function getInstancia() {
            if (  !self::$instancia instanceof self) {
                self::$instancia = new self;
            }
            return self::$instancia;
    }

    public function init($datosBD){
        if ( ! $this->inicializada ) {
            $this->bdDatosConexion = $datosBD;    		
            $this->inicializada = true;
            session_start();
        }
    }

    //Login y logaout
    public function login(Usuario $user){
        $_SESSION['login'] = true;
		$_SESSION['email_usuario'] = $user->getEmail();
		$_SESSION['nombre'] = $user->getNombre();
		$_SESSION['apellido'] = $user->getApellido();
		$_SESSION['password'] = $user->getPassword();
		$_SESSION['telefono'] = $user->getTelefono();
    }

    public function logout(){
        unset($_SESSION['login']);
		unset($_SESSION['email_usuario']);
		unset($_SESSION['nombre']);
		unset($_SESSION['apellido']);
		unset($_SESSION['password']);
		unset($_SESSION['telefono']);
		session_destroy();
    }

    private function compruebaInstanciaInicializada(){
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializada";
	        exit();
	    }
	}

    public function conexionBd(){
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['bd'];
			
			$this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}
}


?>