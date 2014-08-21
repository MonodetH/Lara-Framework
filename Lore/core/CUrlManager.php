<? 
	#
	#CUrlManager class file
	#Manejo de urls amigables
	#

class CUrlManager{
	
	#Miembros
	
	
	
	#Metodos de objeto
	
	#Metodos estaticos
	
	public static function getParsedUrl($inSubdomain) {
		$param = array();
		$url = parse_url($_SERVER['REQUEST_URI']);

		foreach(explode("/", $url['path']) as $p){
			if ($p!='') {$param[] = $p;} 
		}
		unset($param[0]);
		$param = array_values($param);
		return $param;
	}

	public static function getUrl(){
		return URL.$_SERVER['REQUEST_URI'];
	}

	public static function encodeUrl($url){
		// Tranformamos todo a minusculas
		$url = strtolower($url);

		//Rememplazamos caracteres especiales latinos
		$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
		$repl = array('a', 'e', 'i', 'o', 'u', 'n');
		$url = str_replace ($find, $repl, $url);
		
		// Añadimos los guiones
		$find = array(' ', '&', '\r\n', '\n', '+'); 
		$url = str_replace ($find, '-', $url);

		// Eliminamos y Reemplazamos demás caracteres especiales
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$url = preg_replace ($find, $repl, $url);

		return $url;
	}
			
	
}

?>