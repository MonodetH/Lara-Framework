<?php 
	#
	#CBase class file
	#Asistente de operaciones fundamentales
	#
	
	class CBase{

		#
		#Metodos estaticos
		
		#asistente de include. Incluye incluso componentes deshabilitados
		public static function includeComponent($class){
			
			$route = InnerConfig::$componentRoute;
			
			//si existe el componente se incluye
			if(isset($route[$class])){
				include_once(LORE_PATH.$route[$class]);
			}else{
				echo '<h3>Componente '.$class.' no existe</h3>';
			}
		}
		
		#Cargador del Core
		public static function includeCore(){

			$route = InnerConfig::$componentRoute;
			$core = InnerConfig::$coreComponent;
		
			foreach($route as $class => $classRoute){
				if(isset($core[$class]) && $core[$class]){
					include_once(LORE_PATH.$classRoute);
				}
			}
		}
		#Cargador de todos los componentes
		public static function includeHelpers(){

			$route = InnerConfig::$componentRoute;
			$enabled = Config::$config['HelperEnabled'];
		
			foreach($route as $class => $classRoute){
				if(isset($enabled[$class]) && $enabled[$class]){
					include_once(LORE_PATH.$classRoute);
				}
			}
		}

		# Cargador de modelo especifico
		public static function includeModel($model){
			include_once(APP_PATH.'models/'.$model.'.php');
		}

		#Cargador completo de modelos modelos. DEPRECATED
		public static function includeAllModels(){

			$route = Config::$route['Model'];
		
			foreach($route as $model ){
				include_once(APP_PATH.'models/'.$model);
			}
		}

		#disparador de Controlador
		public static function runController($control = 'home',$request = 'render',$data = array()){
			$route = Config::$route['Controller'];
			$_SESSION['LORE']['page']['current']= $control;

			//si existe el controlador lo incluyo
			if(isset($route[$control])){
				$control = $route[$control];
				// Se llama al controlador
				include(APP_PATH.'controllers/'.$control.'.php');
				$controller = new $control($request, $data);
			}elseif(file_exists(APP_PATH.'controllers/'.$control.'.php')){
				include(APP_PATH.'controllers/'.$control.'.php');
				$controller = new $control($request, $data);
			}else{
				echo '<h3>Controlador '.$control.' no existe</h3>';
			}
		}
		
		#Dibujador de vistas
		public static function renderView($view='inicio',$data = array()){
			
			$filename = 'V'.ucwords($view).'.php';

			//si existe la vista la muestro
			if(file_exists(APP_PATH.'views/'.$filename)){
				require(APP_PATH.'views/'.$filename);
			}else{
				echo '<h3>Vista '.$view.' no existe</h3>';
			}
		}

		# Redirector (Solo para actions)
		public static function redirect(){
			$redir = "";
			if(isset($_SESSION['LORE']['page']['redir'])){
				$redir = $_SESSION['LORE']['page']['redir'];
				unset($_SESSION['LORE']['page']['redir']);
			}
			header('Location:'.URL.$redir);
		}
	}
?>
