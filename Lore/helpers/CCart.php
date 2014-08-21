<?
	# 
	# CCart class file
	# Implementacion carrito de compras
	#

	class Cart{

		/* Lista de productos 
		 * estructura: { <sku> => <cantidad> , ... } */
		private $_productos = array();


		/* Funcion agregar */
		public function agregar($sku, $cant){
			if($cant > 0){
				$_productos[$sku] = $cant;
				return true;
			}
			return false;
		}

		/* Funcion eliminar */
		public function eliminar($sku){
			if(array_key_exists($sku, $_productos)){
				unset($_productos[$sku]);
				return true;
			}
			return false;
		}

		/* Funcion modificar */
		public function modificar($sku, $cant){
			if($cant == 0){ $this->eliminar($sku); return; }
			if(array_key_exists($sku, $_productos)){
				$this->agregar($sku, $cant);
				return true;
			}
			return false;
		}

	}

?>