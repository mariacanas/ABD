<?php
require_once __DIR__.'/aplicacion.php';
//require_once __DIR__.'/contacto.php';

/**
 * Configuracion del soporte UTF-8, localizacion (idioma y pais)
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');

date_default_timezone_set('Europe/Madrid');

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'infotel');
define('BD_USER', 'root');
define('BD_PASS', '');

// Inicializa la aplicacion
$app = Aplicacion::getInstancia();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

