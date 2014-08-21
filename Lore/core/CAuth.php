<?
#
#CAuth class file
#Asistente de autenticacion
#

class CAuth{
	
	/** 
	 * Determina si el usuario tiene permisos
	 * 
	 * @return mixed Devuelve un array con la autorizacion del usuario y los permisos minimos requeridos
	 */
	public static function isAuth($auth = array()){
		$user_tipo = 'none';
		
		//determinar el tipo de usuario
		if(isset($_SESSION['user']))
			$user_tipo = $_SESSION['user']['tipo'];

		$autorizado = false; # permisos para el usuario
		$requerido = 'none'; # menor privilegio para ser aprobado

		// Se recorre $auth con un maximo de 2 niveles
		foreach ($auth as $tipoL1 => $value1) {
			if (is_array($value1)) {
				foreach ($value1 as $tipoL2 => $value2){
					if ($tipoL2 == $user_tipo){ 			
						$autorizado = $value2;
					}
					if ($requerido == 'none' && $value2){
						$requerido == $tipoL1;
					}
				}
			}else{
				if ($tipoL1 == $user_tipo){ 			
					$autorizado = $value1;
				}
				if ($requerido == 'none' && $value1==true){
					$requerido = $tipoL1;
				}
			}		
		}

		return array('autorizado' => $autorizado, 'requerido' => $requerido);
	}

	/**
	 * Revisa si el usuario esta logeado, sino pide login
	 *
	 * @return bool True si el ususario tiene los permisos necesarios. False si no lo esta y pide login
	 */
	public static function requireAuth($auth = array()){
		$result = self::isAuth($auth);

		// Si el usuario no está autorizado se redirecciona a login
		if(!$result['autorizado'] && $result['requerido'] != 'none'){
			$_SESSION['LORE']['page']['redir'] = CUrlManager::getUrl();
			return $result['requerido'];
		}
		return true;
	}
}


?>