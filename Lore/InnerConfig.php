<?php 
	
	#
	# Config class file
	# config flags y rutas
	#

	class InnerConfig{

		/* Lista de componentes esenciales */
		public static $coreComponent = array(
			'CAuth' => true,
			'CBase' => true,
			'CModel' => true,
			'CPage' => true,
			'CUrlManager' => true
		);
		

		/* Ruta a componentes del Framework. */
		public static $componentRoute = array(
			// Core components
			'CAuth' => 'core/CAuth.php',
			'CBase' => 'core/CBase.php',
			'CModel' => 'core/CModel.php',
			'CPage' => 'core/CPage.php',
			'CUrlManager' => 'core/CUrlManager.php',

			// Helpers
			'CCart' => 'helpers/CCart.php',
			'CHtml' => 'helpers/CHtml.php'
		);

	}
?>
