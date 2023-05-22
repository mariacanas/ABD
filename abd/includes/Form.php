

<?php


abstract class Form{

    private $formId;

    private $action;

  
    public function __construct($formId, $opciones = array() ){
        $this->formId = $formId;

        $opcionesPorDefecto = array( 'action' => null, );
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action   = $opciones['action'];
        
        if (!$this->action ) {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
   

 
    public function gestiona(){   
        
        if (!$this->formularioEnviado($_POST) ) {
            echo $this->generaFormulario();
        } 
        else {
            $result = $this->procesaFormulario($_POST);
        }
    }

    protected function generaCamposFormulario($datosIniciales){
        return '';
    }

    protected function procesaFormulario($datos){
        return array();
    }

    private function formularioEnviado(&$params) {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

   
    public function generaFormulario(&$datos = array()){

        $html = '';
        $html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generaCamposFormulario($datos);
        $html .= '</form>';
        
        return $html;
    }

  
}