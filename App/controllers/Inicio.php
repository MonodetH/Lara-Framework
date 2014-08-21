<?php 
	#
	#Inicio class file
	#Controlador
	#
	
	class Inicio extends CPage{
		
		// Privilegios
		static protected $auth = array(
			'none' => true
		);

		// funciones ejecutables via $request
		protected $exec = array(
			'render'
		);

		#
		#Metodos
		protected function init(){
			if(isset($_SESSION['data'])){
				$this->data['form']  = $_SESSION['data'];
				unset($_SESSION['data']);
			}
		} 

		protected function render()
		{
			$data=$this->data;
			$this->beginHtml5();
			CBase::renderView('inicio',$data);
			$this->endHtml();
		}	
	}
?>
