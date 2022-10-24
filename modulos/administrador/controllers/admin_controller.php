<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');    
    require_once('modulos/administrador/models/Admin.php');    

    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("admin")){

        $userName = $_SESSION["sistemaExamenes"]["name"];

        $admin = new Admin();

        $data = "";
        $msg = "";
        $studentNumber = 0;
        $testNumber = 0; 

        //numero de alumnos
        $getStudentNum = $admin -> get_students_number();

        if($getStudentNum["status"] == "done"){

            $studentNumber = $getStudentNum["data"];

        }else{

            $studentNumber = $getStudentNum["notice"];
        
        }
        
        //numero de examenes 
        $getTestNum = $admin -> get_test_number();
        
        if($getTestNum["status"] == "done"){

            $testNumber = $getTestNum["data"];

        }else{

            $testNumber = $getTestNum["notice"];
        
        }
        
        //cargar vista
        require_once("modulos/administrador/views/theme/admin_view.php");  

    }else{

         echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }


?>