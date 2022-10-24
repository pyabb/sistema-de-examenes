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

        $student = new Student();

        $userName = $_SESSION["sistemaExamenes"]["name"];

        $data = "";

        $msg = "";

        if(isset($_POST["add-student"])){

            $data = $_POST;

            //agregar alumno
            $addStudent = $student -> add_one($data);

            $msg = $addStudent["notice"];

        }

        $addStudentForm = $student -> get_add_form($msg);

        //cargar vista
        require_once("modulos/administrador/views/theme/admin_add_student_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    


?>