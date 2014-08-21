<?
	#
	# CModel class file
	# Clase base para la creacion de modelos
	#

	class CModel extends CDatabase{
		protected static $_table;
		protected static $_scheme = array();
		/*
		* array(
		*	'id' => array(	'tipo' => 'int', 
		+					'encode' => false,
		+					'default' => NULL)
		* );
		* Tipos: int, text.
		*/

		public static function probarlink(){
			return self::getLink();
		}
		/* Metodo de encriptacion. ES NECESARIA LA IMPLEMENTACION EN CADA MODELO QUE LA UTILICE */
		protected static function encriptar($str,$data = array()){
			return crypt($str);
		}

		/* Devuelve un string con el nombre de las columnas encomadas */
		protected static function columns(){
			$string = '';
			foreach (static::$_scheme as $key => $value) {
				$string .= ($string == '')? $key : (','.$key);
			}
			return $string;
		}

		/* Devuelve un string con los valores encomados */
		protected static function parseInsValues($mysqli,$values = array()){
			$string = '';
			foreach (static::$_scheme as $columna => $options) {
				if(array_key_exists($columna, $values) && $columna != NULL){
					$value = ($options['encode'])? 
						encriptar(trim($values[$columna]),$values) : 
						$mysqli->real_escape_string(trim($values[$columna]));

					if($string != ''){
						$string .= ($options['tipo']=='int' || ($value===NULL && $options['default']=='NULL'))? (','.$value):(",'".$value."'");
					}else{
						$string .= ($options['tipo']=='int' || ($value===NULL && $options['default']=='NULL'))? $value:("'".$value."'");
					}
				}else{
					if($string != ''){
						$string .= ($options['tipo']=='int' || ($value===NULL && $options['default']=='NULL'))? (','.$options['default']):(",'".$options['default']."'");
					}else{
						$string .= ($options['tipo']=='int' || ($value===NULL && $options['default']=='NULL'))? $options['default']:("'".$options['default']."'");
					}
				}
			}
			return $string;
		}

		/* Devuelve un string con los valores encomados */
		protected static function parseUdValues($mysqli,$update = array()){
			$string = '';
			foreach ($update as $key => $value) {
				if(array_key_exists($key, static::$_scheme)){
					$options = static::$_scheme[$key];
					$value = ($options['encode'])? 
						encriptar(trim($value),$update) : 
						$mysqli->real_escape_string(trim($value));

					if($string != ''){
						$string .= ($options['tipo']=='int' || $value===NULL)? (','.$key."=".$value):(",".$key."='".$value."'");
					}else{
						$string .= ($options['tipo']=='int' || $value===NULL)? ($key."=".$value):($key."='".$value."'");
					}
				}
			}
			return $string;
		}

		public static function fetch_all($result,$resulttype = MYSQLI_NUM)
        {
            if (method_exists('mysqli_result', 'fetch_all')) # Compatibility layer with PHP < 5.3
                $res = $result->fetch_all($resulttype);
            else
                for ($res = array(); $tmp = $result->fetch_array($resulttype);) $res[] = $tmp;

            return $res;
        }

		/* Inserta un registro */
		public static function insertar($registro = array()){

			$mysqli = self::connect();
			if($mysqli==NULL){return;}

			$values = self::parseInsValues($mysqli,$registro);
			$query = sprintf("INSERT INTO %s(%s) VALUES(%s);",static::$_table, self::columns(),$values);

			$mysqli->query($query);
			$return = true;
			if($mysqli->affected_rows != 1){
				$return = $mysqli->error;
				$_SESSION['LORE']['data']['error']='Error al insertar registro: '.$return;
			}
			$mysqli->close();
			return $return;
		}

		/* Actualiza el registro <id> */
		public static function actualizar($id,$registro = array()){
			$mysqli = self::connect();
			if($mysqli==NULL){return;}

			if(is_int($id)){$id = strval($id);}
			$values = self::parseUdValues($mysqli,$registro);
			$query = sprintf('UPDATE %s SET %s WHERE id=%s;',static::$_table, $values,$id);

			$mysqli->query($query);

			$return = true;
			if($mysqli->affected_rows != 1){
				$return = $mysqli->error;
				echo 'Error al actualizar registro: '.$return;
			}
			$mysqli->close();
			return $return;
		}

	}


?>