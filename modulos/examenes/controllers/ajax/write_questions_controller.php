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

				case 'getInstructions':

					if(!$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", 
							                          "Faltan datos para obtener instrccciones del examen", 
													  "vacio"); 					

					}else{

						$dataInst = "";

						$idTest = $test -> data_cleaner($_POST["idTest"]);

						$getInstructions = $test -> get_instructions($idTest);

						if($getInstructions["status"] == "done"){

							$instructions = $getInstructions["data"];

						}else{

							$instructions = $getInstructions["notice"];
						
						}

						$data = $test -> status_query($getInstructions["status"], 
							                          $getInstructions["notice"], 
							                          $instructions); 			
						
					}
					
				break;
				case 'addInstructions':

					if(!$test -> forms -> empty_data($_POST["instructions"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Escriba las instrucciones", "vacio"); 					

					}else{

						$dataInst = "";
						$instructions = $_POST["instructions"];
						$idTest = $_POST["idTest"];

						$add = $test -> add_instructions($instructions, $idTest);

						if($add["status"] == "done"){

							$dataInst = $instructions;
						}else{

							$dataInst = $add["data"];
						
						}

						$data = $test -> status_query($add["status"], $add["notice"], $dataInst); 			
						
					}
					
				break;
				case 'addQuestion':

					if(!$test -> forms -> empty_data($_POST["question"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Escriba la pregunta", "vacio"); 					

					}else{

						$dataQuestion = "";
						$question = $_POST["question"];
						$idTest = $_POST["idTest"];

						$add = $test -> add_question($question, $idTest);

						if($add["status"] == "done"){

							$dataQuestion = $add["data"];
						
						}else{

							$dataQuestion = $add["data"];
						
						}

						$data = $test -> status_query($add["status"], $add["notice"], $dataQuestion);
						
					}
					
				break;
				case'getUpdateQuestionForm':

					$idTest = $_POST["idTest"];
					$idQuestion = $_POST["idQuestion"];
					$question = "";

					$getOne = $test -> get_question($idTest, $idQuestion);

					if($getOne["status"] == "done"){

						$question = mysqli_fetch_assoc($getOne["data"]);

						$question = $question["preg_pregunta"];

					}else{

						$question = $getOne["notice"];

					}

					$data = $test -> status_query("done", 
						                          "Mostrando formulario", 
						                          $test -> get_update_questionForm($question)); 			
				break;
				case 'updateQuestion':

					if(!$test -> forms -> empty_data($_POST["question"]) ||
					   !$test -> forms -> empty_data($_POST["idQuestion"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Escriba su pregunta", "vacio"); 					

					}else{

						$dataQuestion = "";
						$question = $_POST["question"];
						$idQuestion = $_POST["idQuestion"];
						$idTest = $_POST["idTest"];

						$update = $test -> set_question($question,
														$idQuestion, 
													    $idTest);

						if($update["status"] == "done"){

							$dataQuestion = $update["data"];
						
						}else{

							$dataQuestion = $update["data"];
						
						}

						$data = $test -> status_query($update["status"], $update["notice"], $dataQuestion); 			
						
					}

				break;
				case'delQuestion':

					if(!$test -> forms -> empty_data($_POST["idQuestion"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", 
							                          "Faltan datos para borrar la pregunta", 
							                          "vacio"); 					

					}else{

						$dataQuestion = "";
						$idQuestion = $_POST["idQuestion"];
						$idTest = $_POST["idTest"];

						$del = $test -> del_question($idQuestion, 
													 $idTest);

						$data = $test -> status_query($del["status"], $del["notice"], $del["data"]); 			
						
					}



				break;
				case 'addCorrectAnswer':

					if(!$test -> forms -> empty_data($_POST["idAnswer"]) || 
						!$test -> forms -> empty_data($_POST["idQuestion"]) || 
						!$test -> forms -> empty_data($_POST["idTest"]) || 
						!$test -> forms -> empty_data_two($_POST["correct"])){

						$data = $test -> status_query("no-data", "Faltan datos para agregar respuesta correcta", "vacio"); 					



					}else{

						$dataInst = "";
						$idQuestion = $_POST["idQuestion"];
						$idAnswer = $_POST["idAnswer"];
						$idTest = $_POST["idTest"];
						$correct = $_POST["correct"];

						$add = $test -> add_correct_answer($idQuestion, 
							                               $idTest, 
							                               $idAnswer,
							                               $correct);

						$data = $test -> status_query($add["status"], $add["notice"], $add["data"]); 			
						
					}
					
				break;
				case'getAddAnswerForm':

					$idQuestion = $_POST["idQuestion"];

					$data = $test -> status_query("done", "Mostrando formulario", 
						                          $test -> get_add_answerForm($idQuestion)); 			
				break;
				case 'addAnswer':

					if(!$test -> forms -> empty_data($_POST["answer"]) ||
					   !$test -> forms -> empty_data($_POST["idQuestion"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Escriba la respuesta", "vacio"); 					

					}else{

						$dataAnswer = "";
						$answer = $_POST["answer"];
						$idQuestion = $_POST["idQuestion"];
						$idTest = $_POST["idTest"];

						$add = $test -> add_answer($answer, 
													$idQuestion, 
													$idTest);

						if($add["status"] == "done"){

							$dataAnswer = $add["data"];
						
						}else{

							$dataAnswer = $add["data"];
						
						}

						$data = $test -> status_query($add["status"], $add["notice"], $dataAnswer); 			
						
					}
					
				break;
				case'getUpdateAnswerForm':

					$idTest = $_POST["idTest"];
					$idQuestion = $_POST["idQuestion"];
					$idAnswer = $_POST["idAnswer"];
					$answer = "";

					$getOne = $test -> get_answer($idTest, $idQuestion, $idAnswer);

					if($getOne["status"] == "done"){

						$answer = mysqli_fetch_assoc($getOne["data"]);

						$answer = $answer["resp_texto"];

					}else{

						$question = $getOne["notice"];

					}

					$data = $test -> status_query("done", 
						                          "Mostrando formulario", 
						                          $test -> get_update_answerForm($answer)); 			
				break;
				case 'updateAnswer':

					if(!$test -> forms -> empty_data($_POST["answer"]) ||
						!$test -> forms -> empty_data($_POST["idAnswer"]) || 
					   !$test -> forms -> empty_data($_POST["idQuestion"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", "Escriba su respuesta", "vacio"); 					

					}else{

						$dataAnswer = "";
						$answer = $_POST["answer"];
						$idQuestion = $_POST["idQuestion"];
						$idAnswer = $_POST["idAnswer"];
						$idTest = $_POST["idTest"];

						$update = $test -> set_answer($answer,
														$idQuestion, 
													    $idTest,
													    $idAnswer);

						if($update["status"] == "done"){

							$dataAnswer = $update["data"];
						
						}else{

							$dataAnswer = $update["data"];
						
						}

						$data = $test -> status_query($update["status"], $update["notice"], $dataAnswer); 			
						
					}

				break;
				case'delAnswer':

					if(!$test -> forms -> empty_data($_POST["idQuestion"]) ||
						!$test -> forms -> empty_data($_POST["idAnswer"]) ||
					   !$test -> forms -> empty_data($_POST["idTest"])){

						$data = $test -> status_query("no-data", 
							                          "Faltan datos para borrar la respuesta", 
							                          "vacio"); 					

					}else{

						$dataQuestion = "";
						$idQuestion = $_POST["idQuestion"];
						$idAnswer = $_POST["idAnswer"];
						$idTest = $_POST["idTest"];

						$del = $test -> del_answer($idQuestion, 
													 $idAnswer,
													 $idTest);

						$data = $test -> status_query($del["status"], $del["notice"], $del["data"]); 			
						
					}



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



           	 