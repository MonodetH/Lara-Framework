<?
	#
	# CPage class file
	# Clase maestra para la construccion de controladores de pagina
	#

	class CPage{

		// Titulo de la pagina
		protected $title = 'A LORE Page';

		// CSS
		protected $styleSheets = array( /* 'default.css' */ );

		// Scripts situacionales 
		//(no estan presentes en todas las paginas de la web)
		protected $scripts = array( /* 'slideshow.js','autocomplete.js' */ );

		// Permisos necesarios para ejecutar controlador
		static protected $auth = array(
			'none' => true,
			'registered' => array(
				'tipo1' => true,
				'tipo2' => true,
				),
			'moderator' => true,
			'admin' => true
		);

		// Funciones ejecutables via request
		protected $exec = array('render');

		// Canal comunicacional 
		protected $data = array();


		// Constructor de clase
		public function __construct($data = array()){
			$this->data = array_merge($this->data, $data);
			$this->data['title']=$this->title;

			if(method_exists($this, 'init')){
				$this->init();
			}
		}

		public function runRequest($request = 'render'){
			// si request es ejecutable 
			if (in_array($request, $this->exec)){
				$this->$request();
			}else{
				return 'NotFound';
			}
		}

		#
		#Metodos

		protected function render(){
			CBase::renderView('home',$this->data);
		}	

		#Doctype y head predefinido
		protected function beginHtml5(){
			echo "<!doctype html>";
			echo "<html><head><meta charset='UTF-8'>";
			echo "<title>".$this->data["title"]."</title>";
			echo $this->htmlCSS();
			echo $this->htmlBaseScripts();
			echo $this->htmlSitScripts();
			echo "</head>";
			echo "<body>";
		}

		#Cierre de etiqueta html
		protected function endHtml(){
			echo $this->htmlSitScripts();
			if(isset($_SESSION['LORE']['data']['mensaje'])) {
				echo "<script language='JavaScript' type='text/javascript'>alert('".$_SESSION['LORE']['data']['mensaje']."');</script>";
				unset($_SESSION['LORE']['data']['mensaje']);
			}
			echo "</body></html>";
		}

		#Cargador de scripts base
		protected function htmlBaseScripts(){
			$html = "";

			$route = Config::$route['Script'];

			foreach ($route as $script => $base) {
				$html.=($base)?"<script type='text/javascript' src='".URL_PATH."scripts/".$script."'></script>":"";
			}

			return $html;
		}

		#Cargador de scripts situacionales
		protected function htmlSitScripts(){
			$html = "";

			foreach ($this->scripts as $script) {
				if(file_exists(APP_PATH.'scripts/'.$script)){
					$html.="<script type='text/javascript' src='".URL_PATH.'scripts/'.$script."'></script>";
				}
			}

			return $html;
		}

		#Cargador de hojas de estilo
		protected function htmlCSS(){
			$html = "";

			foreach ($this->styleSheets as $css) {
				if(file_exists(APP_PATH.'css/'.$css) && $css!=NULL){
					$html.="<link rel='stylesheet' type='text/css' href='".URL_PATH."css/".$css."' />";
				}
			}

			return $html;
		}

		#Mensajes post renderizado
		protected function postRender($data = array()){
			$html = "";

			foreach($data as $script){
				$html.="<script language='JavaScript' type='text/javascript'>".$script."</script>";
			}
		}

		static function isAuth(){
			return CAuth::requireAuth(self::$auth);
		}
	}

?>
