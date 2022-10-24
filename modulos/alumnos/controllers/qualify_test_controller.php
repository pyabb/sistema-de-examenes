<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once("models/Evaluation.php");
    require_once('models/Login.php');

    $login = new Login();
    
    if($login -> is_user_logged() && $login -> is_user_type("alumn")){

        $userName = $_SESSION["sistemaExamenes"]["name"];
        $idStudent = $_SESSION["sistemaExamenes"]["idUser"];
            
        $testName = "";
        $instructions =  "";
        $testQuestions = "";
        $data = "";
        $msgPage = "";
        $questionsList = "";
        $idTest = "";
        $questionsNum = 0;
        $correctNum = 0;
        $incorrectNum = 0;
        $promedio = 0;
        $promMin = 0;
        $itsAprobed = "";
        
        if(isset($_POST["sendTestBtn"])){

            require_once('modulos/examenes/models/Test.php');
                
            $test = new Test();

            $idTest = $_POST["idTest"];
                
            $dataExpire = $test -> get_data_expire($idTest);//obtener la fecha de expiracion

            $dataExpire = mysqli_fetch_assoc($dataExpire["data"]);


            if($test -> verify_expired_time($dataExpire["configEx_fechaDeExpiracion"],
                                                $dataExpire["configEx_horaDeExpiracion"]) &&
                   $dataExpire["exam_status"] == "1"){
                
                //numero de preguntas
                $getNumber = $test -> get_questions_number($idTest);

                if($getNumber["status"] == "done"){

                    $questionsNum = $getNumber["data"];

                }else{
                    
                    $questionsNum = $getNumber["notice"];

                }

                //nombre e instrucciones del examen
                $getTestData = $test -> get_test_data($idTest);

                if($getTestData["status"] == "done"){

                    $testName = $getTestData["data"]["testName"];
                    $instructions = $getTestData["data"]["instructions"];
                    $promMin = $getTestData["data"]["promMin"];

                }else{
                    
                    $msg = $getTestData["notice"];

                }

                
                //preguntas revisadas
                $getQuestions = $test -> get_questions_qualified($idTest, $_POST);

                if($getQuestions["status"] == "done"){
                    
                    $questionsList = $getQuestions["data"]["questions"];

                    $correctNum = $getQuestions["data"]["correctQuestions"];

                    $incorrectNum = $questionsNum - $correctNum; 

                    $promedio = round(($correctNum * 10) / $questionsNum);

                }else{

                    $questionsList = $getQuestions["notice"];

                }


                if($promedio < $promMin){
                
                    $itsAprobed = "No aprobado";

                }else{
                
                    $itsAprobed = "Aprobado";                
                
                }

                //registrar resultados del examen  
                $saveResults = $test -> save_test_results($idTest, 
                                                           $idStudent, 
                                                           $correctNum, 
                                                           $incorrectNum, 
                                                           $promedio);
                
                    
                $msgPage = $saveResults["notice"];

            }else{

                $msgPage = $test -> info_msg("Lo sentimos, el tiempo para enviar respuestas a terminado");

            }

            require_once("modulos/alumnos/views/theme/qualify_test_view.php"); 

        }else{

            header("location: alumno.php");

        } 

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>
