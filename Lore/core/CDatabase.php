<?
/**
 * CDatabase class
 * 
 * Clase tipo singleton que contiene la informacion de la 
 * base de datos, ademas de un enlace a esta via sqli
 */
class CDatabase{

	# Contiene la conexion a la base de datos
	protected static $_mysqli = null;

	/** Evitar la creacion y clonacion de objetos */
	protected function __construct(){}
    protected function __clone(){}

    protected static function connect(){
		if(self::$_mysqli === null){self::getLink();}
    	return self::$_mysqli;
	}

    public static function getLink(){
    	$DB = Config::$config['DB'];
		self::$_mysqli =  new mysqli($DB['server'],$DB['user'],$DB['password'],$DB['db']);
		self::$_mysqli->set_charset("utf8");
		if (self::$_mysqli->connect_errno) {
			$_SESSION['LORE']['data']['error']="Fallo al contenctar a MySQL: (".self::$_mysqli->connect_errno.") ".self::$_mysqli->connect_error;
		}
    }

}

?>