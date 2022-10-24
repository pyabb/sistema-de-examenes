<?php  
	
    require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
 	require_once('../../../../models/Evaluation.php');   
 	require_once('../../../../modulos/examenes/models/Test.php');   

 	$test = new Test(); 	

	if(isset($_POST["request"])){
		
			switch ($_POST["request"]) {

				case 'delStudentEr':

					$idStudent = $_POST["idStudent"];
					$idTest = $_POST["idTest"];

					if($test -> forms -> empty_data($idStudent) ||
					   $test -> forms -> empty_data($idTest)){

						$del = $test -> del_student_er($idTest, $idStudent);
					
						$data = $test -> status_query($del["status"], $del["notice"], $del["data"]); 
							
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



           	 