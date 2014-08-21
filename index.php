<?php
/** 
 * Index
 *
 * Punto de entrada a la web. Crea la aplicacion o dispara un Action
 */

/** Constante APP_PATH. Direccion a los archivos de la aplicacion. */
defined('APP_PATH') or define('APP_PATH',dirname(__FILE__).'/App/');

/** Constante LORE_PATH. Direccion a los archivos del framework. */
defined('LORE_PATH') or define('LORE_PATH',dirname(__FILE__).'/Lore/');

/**
 * Constante URL_PATH.
 * Url a los archivos de la aplicacion (Usado para acceder a archivos via html)
 * Difiere de APP_PATH si la web esta asociada a un subdominio
 */
defined('URL_PATH') or define('URL_PATH','/App/');

/** Constante URL. Url a la pagina de inicio de la aplicacion */
# defined("URL") or define('URL','http://'.$_SERVER['HTTP_HOST'].'/');
defined("URL") or define('URL','http://'.$_SERVER['HTTP_HOST'].'/Lore2/');

/* Se incluye el framework */
require_once(LORE_PATH.'Lore.php');

/* Se incluye la app personalizada (framework dependiente) */
require_once(APP_PATH.'App.php');

$app = new App();

if(isset($_GET['AT'])){
	$app->triggerAction($_GET['AT']);
}else{
	$app->run();
}
?>
