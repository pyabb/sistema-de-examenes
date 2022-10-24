<?php 

	class Login extends Server{
		
		use Messages, Status;

		public function __construct(){
			
			parent::__construct();

			$this -> forms = new Forms();
		
		}

		public function password_validity($password = ""){

			if($this -> forms -> empty_data($password)){
            	
				if (strlen($password) < 4 ) {

					$status = $this -> status_query("no-data", 
						                            "Su password debe contener un minimo de 8 caracteres", 
						                            false);
						
				}else if (strlen($password) > 12 ) {
					
					$status = $this -> status_query("no-data", 
						                            "Su password debe contener un maximo de 12 caracteres",
						                            false);

				}else if (!preg_match('`[a-z]`', $password)) {
					
					$status = $this -> status_query("no-data", 
						                            "Su password debe contener minimo menos una letra minuscula", 
						                            false);
					
				}else if (!preg_match('`[A-Z]`', $password)) {
					
					$status = $this -> status_query("no-data", 
						                            "Su password debe contener minimo una letra mayuscula", 
						                            false);
					
				}else if (!preg_match('`[0-9]`', $password)) {
					
					$status = $this -> status_query("no-data", 
						                            "Su password debe contener minimo un caracter numerico",
						                            false);
					
				}else{

					$status = $this -> status_query("done", 
						                            "Password correcto", 
						                            true);

				}

            }else{

            	$status = $this -> status_query("no-data", 
            		                            "Password vacio para verificacion", 
            		                            false);

            }

            return $status;			

		}

		public function login($user = "", $password = "", $typeUser = ""){

			if(!$this -> forms -> empty_data($user)){
                                
                return $this -> status_query("info", 
                	                         $this -> info_msg('El campo <strong>&nbspusuario&nbsp</strong> esta vacio'));
                
            }else if(!$this -> forms -> empty_data($password)){
                
                return $this -> status_query("info",
                	                        $this -> info_msg('El campo <strong>&nbsppassword&nbsp</strong> esta vacio'));
                
            }else if(!$this -> forms -> empty_data($typeUser)){
                
                return $this -> status_query("info",
                	                        $this -> info_msg('Seleccione un tipo de usuario'));
                
            }else{

				$user = $this -> data_cleaner($user);

				$password = $this -> data_cleaner($password);
        
        		return $this -> user_verify($user, $password, $typeUser);

        	}

		}

		public function user_verify($user, $password, $typeUser = ""){

			//verificacion de tipo de usuario al momento de logearse
			
			$status = "done";

			//busqueda del usuario
			switch ($typeUser) {
				
				case 'admin':
					$sql ="select * from usuarios where usuario = '$user'";	
				break;

				case 'alumn':
					$sql ="select * from alumnos where usuario = '$user'";	
				break;
				
				default:
					$status = "error";
				break;
			
			}

			if($status == "error"){

				//si en el login se manda un tipo de usuario diferente a los aceptados entra aqui

				return $this -> status_query("error", $this -> danger_msg("Tipo de usuario desconocido"), "");

				$search["status"] = "error";
			
			}else{

				//busqueda del usuario

				$search = $this -> search($sql, 
				                     	  "Error al verificar usuario</br>",
				                     	  $this -> success_msg("Usuario encontrado"), 
				                     	  $this -> info_msg("Usuario no registrado o eliminado"),
				                     	  $this -> danger_msg("Error al verificar el usuario"));
	
			}

			if($search["status"] == "done"){

				//si es encontrado entra aqui

				$row = mysqli_fetch_assoc($search["data"]);

				//verificacion de password, pass_verify debuelve false si el password no es correcto
				//y devuelve true si es correcto
				$verifyPass = $this -> pass_verify($password, $row['password']);

				if(!$verifyPass){
                           
                    return $this -> status_query("info", $this -> info_msg('Su contraseña es incorrecta'), "");
                
                }else{                    

                	//anadir datos de usuario a la variable de session
                	$_SESSION['sistemaExamenes']['idUser'] = $row['id'];
                    $_SESSION['sistemaExamenes']['user'] = $row['usuario'];
                    $_SESSION['sistemaExamenes']['name'] = $row['nombre'];
                    $_SESSION['sistemaExamenes']['userType'] = $row['tipoUsuario'];

                    //redireccionar a la pagina que corresponda dependiendo del tipo de usuario
                    $this -> user_type_verify($row["tipoUsuario"]);
                      
                }

			}else{

				return $this -> status_query($search["status"], $search["notice"], $search["data"]);

			}

		}

		public function is_user_logged(){

			//verificacion de usuario logeado

			if(isset($_SESSION["sistemaExamenes"]["idUser"]) &&
			   isset($_SESSION["sistemaExamenes"]["user"]) && 
			   isset($_SESSION["sistemaExamenes"]["name"]) && 
			   isset($_SESSION["sistemaExamenes"]["userType"])){

				return true;

			}else{
			
				return false;
			
			}
		
		}

		public function is_user_type($userType = ""){

			/*metodo para verificacion de tipo de usuario
			su parametro contiene el tipo de usuario que se requiere para acceder a un area del sistema.
			ejemplo: si es la pagina de inicio del admin se coloca is_user_type('admin') y dependiendo del tipo de usuario logeado
			este metodo devolvera falso si se trata de un estudiante o verdadero si es el admin.*/

			if($_SESSION["sistemaExamenes"]["userType"] == $userType){
				
				return true;

			}else{
				
				return false;
			}

		}

		public function user_type_verify($userType = ""){

			//verifcacion de tipo de usuario, para saber a donde redireccionar

			switch ($userType) {
            
            	case 'admin':
            		header("Location:admin.php");
            	break;
            	case 'alumn':
            		header("Location:alumno.php");	                	
            	break;
            	
            	default:
            		echo "No se reconoce el tipo de usuario";
            	break;
            
            }

		}

		public function close(){

			if(isset($_SESSION['colegio']['user'])){

				session_destroy();

				header('Location:index.php');
			
			}else{
			
				return $this -> info_msg("<div id='errorcerrar'>ERROR</div>");
			
			}

		}

	}

?>