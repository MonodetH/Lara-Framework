<?

/**
 * Lore Class.
 *
 * Contiene los metodos basicos para la ejecucion de la aplicacion
 */
class Lore{

	# true si la app se encuentra en un subdominio
	protected $_subdomain = false;

	#seteo inicial
	public function __construct(){
		
		// Recuperar datos de sesion
		session_start();

		# InnerConfig (Configuracion de framework)
		require_once(LORE_PATH.'InnerConfig.php');
		# Config
		require_once(APP_PATH.'Config.php');

	}

	
	# Punto de partida de la aplicacion
	public function run(){
		// se obtiene url por partes
		$url = CUrlManager::getParsedUrl($this->_subdomain);
		
		// se incuye el controlador y se guarda su nombre
		$controllerName = (isset($url[0]))?$this->includeController($url[0]):$this->includeController();
		if($controllerName){
			// se revisa si el usuario esta autorizado para ingresar a la pagina
			$isAuth = $controllerName::isAuth();

			if($isAuth == true){
				$controller = new $controllerName();
				if(isset($url[1])){
					$controller->runRequest($url[1]);
				}else{
					$controller->runRequest();
				}
			}else{
				$this->includeController('login');
				$controller = new Login(array('authRequired'=>$isAuth));
				$controller->runRequest('requireLogin');
			}
		}else{
			echo "404";
		}

		// //redireccionar a controlador
		// if(isset($url[0])){
		// 	if(isset($url[1])){
		// 		CBase::runController($url[0],$url[1]);
		// 	}else{
		// 		CBase::runController($url[0]);			
		// 	}
		// }else{
		// 	CBase::runController();
		// }
	}
	#disparador de Controlador
	private function includeController($control = 'home',$request = 'render',$data = array()){
		$route = Config::$route['Controller'];
		$_SESSION['LORE']['page']['current']= $control;

		//si existe el controlador lo incluyo
		if(isset($route[$control])){
			$control = $route[$control];
			// Se llama al controlador
			include(APP_PATH.'controllers/'.$control.'.php');
			#$controller = new $control($request, $data);
			return $control;
		}elseif(file_exists(APP_PATH.'controllers/'.$control.'.php')){
			include(APP_PATH.'controllers/'.$control.'.php');
			#$controller = new $control($request, $data);
			return $control;
		}else{
			return NULL;
		}
	}
	

	# Lanzador de actions (form request)
	public final function triggerAction($action){
		require(APP_PATH.'actions/'.$action.'.php');
		$this->redirect();
	}
	
	# Redireccionador (Solo para actions)
	public function redirect(){
		$redir = "";
		if(isset($_SESSION['LORE']['page']['redir'])){
			$redir = $_SESSION['LORE']['page']['redir'];
			unset($_SESSION['LORE']['page']['redir']);
		}else{
			$redir = URL;
		}
		header('Location:'.$redir);
	}
}

/** Constante ACTION. Metodo abreviado para definir actions en forms */
defined("ACTION") or define('ACTION',URL.'?AT=');

spl_autoload_register(function($class) {
    if(file_exists(LORE_PATH.'core/'.$class.'.php')){include(LORE_PATH.'core/'.$class.'.php');}
});
spl_autoload_register(function($class) {
	if(file_exists(APP_PATH.'models/'.$class.'.php')){include(APP_PATH.'models/'.$class.'.php');}
});
spl_autoload_register(function($class) {
	if(file_exists(LORE_PATH.'helpers/'.$class.'.php')){include(LORE_PATH.'helpers/'.$class.'.php');}
});


?>