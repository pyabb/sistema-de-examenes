<?php  

    session_start();
    
    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');
    require_once('models/Evaluation.php');
    
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("alumn")){

        $userName = $_SESSION["sistemaExamenes"]["name"];
        $idStudent = $_SESSION["sistemaExamenes"]["idUser"];

        $testName = "";
        $instructions =  "";
        $testQuestions = "";
        $msg = "";
        $questionsList = "";
        $typeBtn = "hidden";
        $hide = "";
        $time = "";
        $timeVal = "";
        $questionsNumber = 0;
            
        if(isset($_GET["examen"])){

            require_once('modulos/examenes/models/Test.php');

            $test = new Test();

            $idTest = $_GET["examen"];

            $getTest = $test -> its_done_test($idTest, $idStudent);
          
            if($getTest["status"] == "no-data"){

                $dataExpire = $test -> get_data_expire($idTest);//obtener la fecha de expiracion

                $dataExpire = mysqli_fetch_assoc($dataExpire["data"]);

                //verificacion para ver si el alumno aun puede hacer el examen
                //se verifica que no haya pasado la fecha y que el examen este activo
                if($test -> verify_expired_time($dataExpire["configEx_fechaDeExpiracion"],
                                                $dataExpire["configEx_horaDeExpiracion"]) &&
                   $dataExpire["exam_status"] == "1"){

                    //verificar si ya se puede hacer elexamen 
                    if($test -> verify_do_dateTime($dataExpire["configEx_fechaDeAplicacion"], 
                                                   $dataExpire["configEx_horaDeAplicacion"])){


                        $idStudent = $_SESSION["sistemaExamenes"]["idUser"];
                        $data = "";
                        $idTest = $_GET["examen"];

                        $timeVal = strtotime($dataExpire["configEx_fechaDeExpiracion"]." ".$dataExpire["configEx_horaDeExpiracion"]);//valor que va en input oculto, el cual, se ocupara en js para hacer la medicion del tiempo restante

                        //obtener el tiempo restante del examen 
                        $getExamTime = $test -> get_exam_time($dataExpire["configEx_horaDeExpiracion"], 
                                                              $dataExpire["configEx_fechaDeExpiracion"], 
                                                              $test -> time,
                                                              $test -> date);

                        $time = explode(":", $getExamTime);//dividir el tiempo en horas y minutos

                        $hours = $time[0];
                        $minuts = $time[1];

                        //mostrar las horas y minutos restantes
                        $time = "<span class='time-item time-hours' id='hours'>$hours</span>
                                 <span class='time-item time-points'>:</span>
                                 <span class='time-item time-minuts' id='minuts'>$minuts</span>";
                        
                        //obtenet nombre e instrucciones del examen
                        $getTestData = $test -> get_test_data($idTest);

                        if($getTestData["status"] == "done"){

                            $testName = $getTestData["data"]["testName"];
                            $instructions = $getTestData["data"]["instructions"];

                        }else{
                            
                            $msg = $getTestData["notice"];

                        }

                        //preguntas 
                        $getQuestions = $test -> get_questions_list($idTest);

                        if($getQuestions["status"] == "done"){

                            $questionsList = $getQuestions["data"]; 
                            $typeBtn = "submit";

                        }else{

                            $questionsList = $getQuestions["notice"];

                        }

                        //obtener el numero de de preguntas realizadas
                        $getQuestionsNumber = $test -> get_questions_number($idTest);
                        $questionsNumber = $getQuestionsNumber["data"];

                    }else{

                        $msg = $test -> info_msg("Ingrese en la hora indicada");

                    }                    

                }else{

                    
                    $msg = $test -> info_msg("La fecha para hacer este examen ha expirado");

                }

                
            }else{

                $hide = "hidden";

                $msg = $test -> info_msg("Este examen ya fue realizado");

            }


        }

        //cargar vista 
        require_once("modulos/alumnos/views/theme/do_test_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>
