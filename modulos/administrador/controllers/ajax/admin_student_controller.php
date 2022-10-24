<?php  
	
    require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
 	require_once('../../../../modulos/alumnos/models/Student.php');   

 	$student = new Student(); 	

	if(isset($_POST["request"])){
		
			switch ($_POST["request"]) {

				case 'getSetForm':

					$idStudent = $_POST["idStudent"];

					if($student -> forms -> empty_data($idStudent)){

						$form = $student -> get_set_form($idStudent);
					
						$data = $student -> status_query($form["status"], $form["notice"], $form["data"]); 
							
					}else{

						$data = $this -> status_query("no-data", "Hay campos vacios", "vacio");

					}

				break;
				case 'updateStatus':

					$idStudent = $_POST["idStudent"];

					$status = $_POST["status"];

					if($student -> forms -> empty_data($idStudent) ||
					   $student -> forms -> empty_data($status)){

						$update = $student -> set_status($idStudent, $status);
					
						$data = $student -> status_query($update["status"], $update["notice"], $update["data"]); 
							
					}else{

						$this -> status_query("no-data", "Hay campos vacios", "vacio");

					}

				break;
				case 'updateStudent':

					$update = $student -> set_student($_POST);
					
					$data = $student -> status_query($update["status"], $update["notice"], $update["data"]); 
							
				
				break;
				case 'resetPass':

					$idStudent = $_POST["idStudent"];

					if($student -> forms -> empty_data($idStudent)){

						$reset = $student -> reset_password($idStudent);
					
						$data = $student -> status_query($reset["status"], $reset["notice"], $reset["data"]); 
							
					}else{

						$this -> status_query("no-data", "Hay campos vacios", "vacio");

					}

				break;
				case 'delStudent':

					$idStudent = $_POST["idStudent"];

					if($student -> forms -> empty_data($idStudent)){

						$del = $student -> del_student($idStudent);
					
						$data = $student -> status_query($del["status"], $del["notice"], $del["data"]); 
							
					}else{

						$data = $student -> status_query("no-data", 
							                          "Los datos enviados no son suficientes para eliminar el estudiante", 
							                          "vacio");

					}

				break;
				default:
				
					$data = $admin -> status_query("error", "Request no valida", "error");
				
				break;
			
			}

	}else{

		$data = $admin -> status_query("error", "No se identifico request", "error");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 