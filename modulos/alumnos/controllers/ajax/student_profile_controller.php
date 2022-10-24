<?php  
	
	session_start();

    require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
    require_once('../../../../models/Login.php');	
 	require_once('../../models/Student.php');   

 	$student = new Student(); 	

	if(isset($_POST["request"])){

			$studentId = $_SESSION["sistemaExamenes"]["idUser"];

			switch ($_POST["request"]) {

				case 'updateDataStudent':

					$user = $_POST["user"];
					$name = $_POST["name"];
					$apellidos = $_POST["apellidos"];


					if($student -> forms -> empty_data($studentId) ||
					   $student -> forms -> empty_data($user) ||
					   $student -> forms -> empty_data($name) ||
					   $student -> forms -> empty_data($apellidos)){

						$update = $student -> set_profile_data($user, $name, $apellidos, $studentId);
					
						$data = $student -> status_query($update["status"], $update["notice"], $update["data"]); 
							
					}else{

						$this -> status_query("no-data", "Hay campos vacios", "vacio");

					}

				break;
				case 'updatePassword':

					$password = $_POST["password"];

					$passwordConfirm = $_POST["passwordConfirm"];

					if($student -> forms -> empty_data($studentId) &&
					   $student -> forms -> empty_data($password) &&
					   $student -> forms -> empty_data($passwordConfirm)){

						$update = $student -> set_student_password($studentId, $password, $passwordConfirm);
					
						$data = $student -> status_query($update["status"], $update["notice"], $update["data"]); 
							
					}else{

						$data = $student -> status_query("no-data", "Su password o confirmacion de password estan vacios", "vacio");

					}

				break;
				default:
				
					$data = $student -> status_query("error", "Request no valida", "failed");
				
				break;
			
			}

	}else{

		$data = $admin -> status_query("error", "No se identifico request", "error");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 