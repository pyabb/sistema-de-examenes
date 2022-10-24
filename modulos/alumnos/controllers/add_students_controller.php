<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');
    require_once('modulos/alumnos/models/Student.php');
    
    $student = new Student();

    $data = "";

    $msg = "";

    if(isset($_POST["add-student"])){

        $data = $_POST;

        //agregar alumno
        $addStudent = $student -> add_one($data);

        $msg = $addStudent["notice"];

    }

    $addStudentForm = $student -> get_add_form($msg);

    require_once("modulos/alumnos/views/theme/add_student_view.php");  

?>