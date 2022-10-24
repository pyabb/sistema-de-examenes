<?php  

    session_start();
    require_once("models/config.php");
    require_once("classes/Messages.php");
    require_once("classes/status.php");
    require_once("models/config.php");
    require_once("models/Server.php");
    require_once("models/Login.php");
    require_once("models/Evaluation.php");
    require_once("classes/Forms.php");
            
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("admin")){ 
		
		$userName = $_SESSION["sistemaExamenes"]["name"];

        require_once("modulos/examenes/models/Test.php");

        $test = new Test();

        $data = "";
        
        $msg = "";

        if(isset($_POST["add-testBtn"])){

            $testName = $_POST["testName"];

           if($test -> forms -> empty_data($testName)){

                //agregar examen
                $addTest = $test -> add_one($_POST);    

                $msg = $addTest["notice"];


           }else{

                $msg = $test -> info_msg("Introdusca el nombre del examen");

           } 

        }
        
        //cargar tabla con lista de examenes    
        $dataTable = $test -> show_test();

        //cargar vista 
        require_once("modulos/examenes/views/theme/tests_view.php");

    }else{
                
        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";
    
    }

        

?>