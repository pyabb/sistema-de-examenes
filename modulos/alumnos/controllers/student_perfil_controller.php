<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');
    
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("alumn")){

        $userName = $_SESSION["sistemaExamenes"]["name"];
        $userId = $_SESSION["sistemaExamenes"]["idUser"];

        require_once('modulos/alumnos/models/Student.php');    

        $student = new Student();

        $data = "";
        $msg = "";
        $typeUser = "none";

        //obtener formulario para editar alumno
        $getSetForm = $student -> get_set_form($userId);

        if($getSetForm["status"] == "done"){

            $setForm = $getSetForm["data"];

        }else{

            $setForm = $getSetForm["notice"];

        }

        //cargar vista
        require_once("modulos/alumnos/views/theme/student_profile_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>