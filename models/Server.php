<?php 

	class Server{
		
		use Status, Messages;
		
		protected $connection;
		private $db;
		private $host;
		private $user;
		private $password;
		private $status;

		public function __construct(){	
			
			$this->status = "none";
			
			$this -> db = DB;
			$this -> host = HOST;
			$this -> user = USER;
			$this -> password = PASSWORD;

			$this -> connection = mysqli_connect($this->host, $this->user, $this->password, $this->db) or die ("Error al conectar con servidor".mysqli_error());

			$this -> dateTime = date("Y/m/d H:i:s");
			$this -> date = date("Y/m/d");
			$this -> time = date("H:i:s");

		}

		protected function search($query = "", 
			                      $errorSqlMsg  = "", 
			                      $doneMsg  = "", 
			                      $noDataMsg  = "", 
			                      $errorMsg  = ""){

			//buscar registros

			if($query == ""){
				
				//si no se introduce la consulta                                                                               
				$data  = $this -> status_query("no-data", "No ha introducido su consulta");				

			}else{

				if($errorSqlMsg == ""){

					$errorSqlMsg == "Error en consulta";

				}
				if($doneMsg == ""){

					$doneMsg == "Consulta exitosa"; 

				}
				if($noDataMsg == ""){

					$errorMsg = "Error en conuslta";

				}
				if($errorMsg == ""){

					$errorMsg = "Error en conuslta";

				}

				if(SHOW_ERRORS == true){
					
					//mostrar errores con detalles 
					$search = mysqli_query($this->connection, $query) or die ($errorSqlMsg."<br>".mysqli_error($this -> connection));

				}else{

					//mostrar error sin detalle
					$search = mysqli_query($this->connection, $query);

				}				
				
				if($search == true){

					$num_rows = mysqli_num_rows($search);//obtener el numero de registros
			
					if($num_rows > 0){

						$data  = $this -> status_query("done", $doneMsg, $search);

					}else{

						$data  = $this -> status_query("no-data", $noDataMsg, "vacio");

					}

				}else{

					$data  = $this -> status_query("error", $errorMsg, "error");

				}

			}

			return $data; 
		
		}

		protected function crud($query = "", 
			                    $errorSqlMsg = "",
			                    $doneMsg ="",
			                    $errorMsg = ""){

			//realizar consultas como insert, update, delete

			//verificar si se ha introducido consulta
			if($query == ''){

				$data = $this -> status_query("done", "No ha introducido su consulta");

			}else{

				//mensajes genericos
				if($errorSqlMsg == ""){

					$errorSqlMsg == "Error en consulta";

				}
				if($doneMsg == ""){

					$doneMsg == "Consulta exitosa"; 

				}
				if($errorMsg == ""){

					$errorMsg = "Error en consulta";

				}

				if(SHOW_ERRORS == true){
					
					$crud = mysqli_query($this->connection, $query) or die ($errorSqlMsg.mysqli_error($this->connection));

				}else{

					$crud = mysqli_query($this->connection, $query);

				}
				
	
				if($crud){

					$data = $this ->status_query("done", $doneMsg);

				}else{

					$data = $this ->status_query("error", $errorMsg);

				}
				
			}

			return $data;

		}

		public function data_cleaner($data){

			//limpiar datos a ingresar en la base de datos

			$data_clean = htmlspecialchars($data);
			 
			$data_clean = mysqli_real_escape_string($this->connection, $data);
			
			return $data_clean;	
		
		}

		protected function crypt_md5($password){
			
			//encriptar con md5
			$md5crypt=md5($password);
			
			return $md5crypt;

		}


		protected function crypt_data($data){
		 	
		 	//encriptar con password_hash

		 	$timeTarget = 0.05;//50 milisegundos 
			
			$coste = 8;
			
			do {
				
				$coste++;
				$inicio = microtime(true);
				$opciones["cost"]=$coste;
				$hash=password_hash($data, PASSWORD_BCRYPT,['cost'=>$coste]);//password_hash(contraseña,algoritmo para crear el hash,array asociativo de opciones);
				$fin = microtime(true);
			
			}while (($fin - $inicio) < $timeTarget);
			
			return $hash;	
		
		}
		
		public function pass_verify($data, $hash){
			
			//verificar contraseña correcta

			$match=password_verify($data, $hash);
			
			return $match;
		
		}

		public function verify_expired_time($date = "", $hour = ""){

			//fecha de expiracion
			$dateTimeExp = strtotime($date." ".$hour);
            
            //fecha actual
            $dateTime = strtotime(date("d-m-Y H:i:s", time()));
           
            if($dateTime < $dateTimeExp){

            	return true;

            }else{

            	return false;

            }

		}
	
	}
?>