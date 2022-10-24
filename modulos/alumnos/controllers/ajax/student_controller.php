<?php  

	require_once('../../../../classes/config.php');
    require_once('../../../../classes/Forms.php');
    require_once('../../../../classes/Messages.php');
    require_once('../../../../classes/status.php');
    require_once('../../../../classes/Server.php');
    require_once('../../../../modulos/salones/classes/Classrooms.php');
    require_once('../../../../modulos/cursos/classes/Courses.php');
 	require_once('../../classes/Student.php');   

 	$student = new Student(); 	

	if(isset($_POST["request"])){

		$request = json_decode($_POST["request"], true);

		if(isset($request["request"])){

			switch ($request["request"]) {

				case 'getDataStudent':

					$getData = $student -> get_one($request["idStudent"]);
					
					if($getData["status"] == "done"){

						$dataStudent = mysqli_fetch_assoc($getData["data"]);

						$data = $student -> status_query("done", "Datos obtenidos exitosamente", $dataStudent); 
						
		            }else{

						$data = $student -> swicth_status_query($getData["status"], "", 
							                                    "Sin datos que mostrar", 
							                                    "Error al obtener los datos del alumno");

					} 	

				break;
				case 'setStudent':
					
					$data = array("nombre" => $request["nombre"],
								   "nacimiento" => $request["fechaNacimiento"],
								   "matricula" => $request["matricula"],
								   "curso" => $request["id_curso"],
								   "apellidos" => $request["apellido"],
								   "telefono" => $request["telefono"],
								   "expediente" => $request["expediente"],
								   "salon" => $request["id_salon"],
								   "idStudent" => $request["idStudent"]);

					$setOne = $student -> set_one($data);

					if($setOne["status"] == "done"){

						$data = $student -> status_query("done", $setOne["notice"]); 
						
		            }else{

						$data = $student -> status_query("error", $setOne["notice"]);

					}

				break;
				default:
				
					$data = $student -> status_query("failed", "Request no valida", "failed");
				
				break;
			
			}

		}else{

			$data = $student -> status_query("failed", "No se identifico request en json", "failed");

		}

	}else{

		$data = $student -> status_query("failed", "No se identifico request", "failed");

	}

	$jsonData = json_encode($data);

	echo $jsonData;

?>



           	 