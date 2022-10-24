<?php  

    session_start();
    require_once("classes/Messages.php");
    require_once("classes/status.php");
    require_once("models/config.php");
    require_once("models/Server.php");
    require_once("models/Login.php");
    require_once('models/Evaluation.php');
    require_once("classes/Forms.php");
        
    $login = new Login();

    if($login -> is_user_logged() && $login -> is_user_type("admin")){ 
				
        $userName = $_SESSION["sistemaExamenes"]["name"];

        require_once("modulos/examenes/models/Test.php");

        $test = new Test();

        $testName = "";
        $idTest = "";
        $instructions = "";
        $questions = "";

        if(isset($_GET["examen"])){

            $idTest = $_GET["examen"];

            //cargar el examen seleccionado mediante su id
            
            $search = $test -> get_one($idTest);

            if($search["status"] == "done"){

                $data = mysqli_fetch_assoc($search["data"]);

                $testName = $data["exam_nombre"];
                $idTest = $data["exam_id"];

            }

            $dataTest = $test -> get_data_test($idTest);

        	$instructions = $dataTest["data"]["instructions"];

        	$questions = $dataTest["data"]["questions"];

        }

        require_once("modulos/examenes/views/theme/write_test_view.php");

    }else{
            
        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";
    
        
    }


?>
