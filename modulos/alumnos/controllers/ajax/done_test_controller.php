<?php  
	
	session_start();

	require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
    require_once('../../../../models/Evaluation.php');
    require_once('../../../../modulos/examenes/models/Test.php');
 	require_once('../../models/Student.php');   


 	$student = new Student(); 	
 	$test = new test(); 	

	if(isset($_POST["request"])){
		
			switch ($_POST["request"]) {

				case 'page-test':

					$testList = "";
					$idStudent = $_SESSION["sistemaExamenes"]["idUser"];
					$page = $_POST["page"];
					$totalItems = $_POST["totalItems"];

					$getTestData = $test -> get_done_test($idStudent, $totalItems, $page);

			        if($getTestData["status"] == "done"){

			            $testList = $getTestData["data"];

			        }else{
			            
			            $pageMsg = $getTestData["notice"];

			        }

					$data = $student -> status_query($getTestData["status"], $getTestData["notice"], $testList);;	

				break;
				default:
				
					$data = $student -> status_query("failed", "Request no valida", "failed");
				
				break;
			
			}


	}else{

		$data = $student -> status_query("failed", "No se identifico request", "failed");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 