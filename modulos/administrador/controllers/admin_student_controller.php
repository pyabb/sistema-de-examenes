<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');
    require_once('modulos/alumnos/models/Student.php');
    
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("admin")){

        $userName = $_SESSION["sistemaExamenes"]["name"];

        $student = new Student();

        $data = "";
        $msg = "";
        $table = "";

        //obtener una lista de los alumnos registrados
        $getData = $student -> get_all();

        if($getData["status"] == "done"){

            //colocar la lista de alumnos en una tabla
            $table = $student -> admin_student_table($getData["data"]);

        }else{

            $table = $login -> status_notice($getData["status"], $getData["notice"]);

        }

        //cargar vista
        require_once("modulos/administrador/views/theme/admin_student_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>