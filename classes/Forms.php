<?php 

	class Forms{
		
		function __construct(){
			
		}

		public function empty_data($data = ""){

			//verificar datos vacios en campos

			if($data != "" && $data != null && 
			   $data != "undefined" &&  !empty($data) ||
			   $data != 0){

				return true;

			}else{

				return false;
			
			}

		}

		public function empty_data_two($data = ""){

			//verificar datos vacios de formulario no verifica con empty

			if($data == "" && $data == null && 
			   $data == "undefined" && $data != 0){

				return false;

			}else{

				return true;
			
			}

		}

	}

?>