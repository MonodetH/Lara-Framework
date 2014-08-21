<?php 
	
	#
	# Config class file
	# config flags y rutas
	#

	class Config{

		public static $route = array(
			'Controller' => array(
				'home' => 'Inicio'
				),
			'Script' => array()
		);

		
		public static $config = array(
			/* Datos de base de datos */
			'DB' => array(
				'server' => 'localhost',
				'db' => 'laratest',
				'user' => 'root',
				'password' => ''
				),

			/* Componentes activados */
			'HelperEnabled' => array(
				// Helpers.
				'CCart' => false,
				'CHtml' => true
				),

			
		);

	}
?>
