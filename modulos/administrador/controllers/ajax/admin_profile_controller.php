<?php  
	
	session_start();

    require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
    require_once('../../../../models/Login.php');
 	require_once('../../models/Admin.php');   

 	$admin = new Admin(); 	

	if(isset($_POST["request"])){

		$idUser = $_SESSION["sistemaExamenes"]["idUser"];
		
			switch ($_POST["request"]) {

				case 'updateDataAdmin':

					$user = $_POST["user"];

					$name = $_POST["name"];

					if($admin -> forms -> empty_data($idUser) &&
					   $admin -> forms -> empty_data($user) &&
					   $admin -> forms -> empty_data($name)){

						$update = $admin -> set_profile_data($idUser, 
							                                 $user, 
							                                 $name);
					
						$data = $admin -> status_query($update["status"], $update["notice"], $update["data"]); 
							
					}else{

						$data = $admin -> status_query("no-data", "Hay campos vacios", "vacio");

					}

				break;
				case 'updatePassword':

					$password = $_POST["password"];

					$passwordConfirm = $_POST["passwordConfirm"];

					if($admin -> forms -> empty_data($idUser) && 
					   $admin -> forms -> empty_data($password) &&
					   $admin -> forms -> empty_data($passwordConfirm)){

						$update = $admin -> set_admin_password($idUser,
							                                   $password, 
							                                   $passwordConfirm);
					
						$data = $admin -> status_query($update["status"], $update["notice"], $update["data"]); 
							
					}else{

						$data = $admin -> status_query("no-data", 
							                           "Su password o confirmacion de password estan vacios", 
							                            "vacio");

					}

				break;
				default:
				
					$data = $admin -> status_query("error", "Request no valida", "failed");
				
				break;
			
			}

	}else{

		$data = $admin -> status_query("error", "No se identifico request", "error");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 