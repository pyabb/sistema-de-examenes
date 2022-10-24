<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Evaluation.php');                     
    require_once('models/Login.php');
    
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("alumn")){

        $userName = $_SESSION["sistemaExamenes"]["name"];
        $idStudent = $_SESSION["sistemaExamenes"]["idUser"];
        
        require_once('modulos/examenes/models/Test.php');
       
        $test = new Test();

        $data = "";
        $msg = "";
        $testList = "";
        
        //obtener lista de examenes que puede hacer el alumno
        $getData = $test -> get_student_testList($idStudent);

        if($getData["status"] == "done"){

            $testList = $getData["data"];

        }else{

            $testList = $getData["notice"];

        }

        $time = date("Y/m/d H:i:s");

        //cargar vista
        require_once("modulos/alumnos/views/theme/student_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>
