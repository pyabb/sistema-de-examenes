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
    
    if($login -> is_user_logged() && $login -> is_user_type("admin")){

        $userName = $_SESSION["sistemaExamenes"]["name"];

        $eval = new Evaluation();

        $data = "";
        $msg = "";
        $table = "";

        //obtener una lista de los examenes que se ha hecho
        $getData = $eval -> get_all();

        if($getData["status"] == "done"){

            //colocar los datos en una tabla
            $table = $eval -> get_eval_table($getData["data"]);

        }else{

            $table = $getData["notice"];

        }

        //cargar vista
        require_once("modulos/administrador/views/theme/evaluations_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>