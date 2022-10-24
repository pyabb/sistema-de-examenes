<?php  

	require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../models/config.php');
    require_once('../../../../models/Server.php');
 	require_once('../../../../models/Evaluation.php');
 	require_once('../../models/Test.php');
 
 	$test = new Test(); 	

	if(isset($_POST["request"])){
	
			switch ($_POST["request"]) {

			
				case'getUpdateTestForm':

					$idTest = $_POST["idTest"];
					$testName = "";

					$getName = $test -> get_test_name($idTest);//obtener nombre del examen

					if($getName["status"] == "done"){

						$testName = $getName["data"];

					}else{

						$testName = $getName["notice"];

					}

					$data = $test -> status_query("done", 
						                          "Mostrando formulario", 
						                          $test -> get_update_testForm($testName)); 			
				break;
				case 'updateTestName':

					if(!$test -> forms -> empty_data($_POST["testName"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Falta el nombre del examen", "vacio"); 					

					}else{

						$dataTest = "";
						$testName = $_POST["testName"];
						$idTest = $_POST["idTest"];

						$update = $test -> set_test_name($testName,
														$idTest);//cambiar nombre del examen

						if($update["status"] == "done"){

							$dataTest = $update["data"];
						
						}else{

							$dataTest = $update["data"];
						
						}

						$data = $test -> status_query($update["status"], $update["notice"], $dataTest); 			
						
					}

				break;
				case'delTest':

					if(!$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", 
							                          "Faltan datos para borrar el examen", 
							                          "vacio"); 					

					}else{

						$idTest = $_POST["idTest"];

						$del = $test -> del_test($idTest);//borrar examen

						$data = $test -> status_query($del["status"], $del["notice"], $del["data"]); 			
						
					}



				break;
				case 'updateTestStatus':

					if(!$test -> forms -> empty_data_two($_POST["status"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Faltan datos", "vacio"); 					

					}else{

						$newStatus = "";
						$status = $_POST["status"];
						$idTest = $_POST["idTest"];

						$update = $test -> set_status_test($status,
													       $idTest);//actualizar estado

						if($update["status"] == "done"){

							$newStatus = $update["data"];
						
						}else{

							$newStatus = $update["data"];
						
						}

						$data = $test -> status_query($update["status"], $update["notice"], $newStatus); 			
						
					}

				break;
				case'getConfigTestData':

					$idTest = $_POST["idTest"];

					$getData = $test -> get_config_testData($idTest);//obtener nombre del examen

					$data = $test -> status_query($getData["status"], 
						                          $getData["notice"], 
						                          $getData["data"]); 			
				break;
				case 'updateTestConfig':

					$hourAp = $_POST["hourAp"];
					$dateAp = $_POST["dateAp"];
					$hourEx = $_POST["hourEx"];
					$dateEx = $_POST["dateEx"];
					$promMin = $_POST["promMin"];
					$idTest = $_POST["idTest"];

					$update = $test -> set_test_config($hourAp,
													   $dateAp,
													   $hourEx,
													   $dateEx,
													   $promMin,
												       $idTest);//actualizar configuracion

					$data = $test -> status_query($update["status"], $update["notice"], $update["data"]); 			
					

				break;
				default:
					
					$data = $test -> status_query("error", "Request no valida", "data"); 			

				break;

			}

	}else{

		$data = $test -> status_query("error", "No se identifico request", "error");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 