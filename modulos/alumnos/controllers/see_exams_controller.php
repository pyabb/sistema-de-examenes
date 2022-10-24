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

        $pageMsg = "";
        $testList = "";
            
        require_once('modulos/examenes/models/Test.php');
        
        $test = new Test();

        $data = "";
        
        //obtener los examenes que realizo el alumno
        $getTestData = $test -> get_done_test($idStudent, "4", "");

        if($getTestData["status"] == "done"){

            $testList = $getTestData["data"];

        }else{
            
            $pageMsg = $getTestData["notice"];

        }

        //obtener el numero de examenes realizados
        $testNumber = $test -> get_doneTest_num($idStudent);
        
        require_once("modulos/alumnos/views/theme/see_exams_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>
