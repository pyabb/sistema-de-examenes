<?php  

    session_start();

    require_once('classes/Forms.php');
    require_once('classes/Messages.php');
    require_once('classes/status.php');
    require_once('models/config.php');
    require_once('models/Server.php');
    require_once('models/Login.php');
    require_once('modulos/alumnos/models/Student.php');
    require_once('modulos/examenes/models/Test.php');
    require_once('models/Evaluation.php');
      
     $login = new Login();
      
    if($login -> is_user_logged() && $login -> is_user_type("admin")){

        $userName = $_SESSION["sistemaExamenes"]["name"];
        $idTest = "";

        if(isset($_GET["examen"])){

            
            $eval = new Evaluation();
            $test = new Test();


            $idTest = $_GET["examen"];
            $data = "";
            $msg = "";
            $testName = "";
            $table = "";

            //obtener nombre del examen
            $getName = $test -> get_test_name($idTest);

            if($getName["status"] == "done"){

                $testName = $getName["data"];

            }else{

                $testName = $getName["notice"];

            }

            //obtener lista de alumnos que realizaron el examen
            $getData = $eval -> get_studentsBy_test($idTest);

            if($getData["status"] == "done"){

                $table = $getData["data"];

            }else{

                $table = $getData["notice"];

            }

            //cargar vista 
            require_once("modulos/administrador/views/theme/evaluated_students_view.php");  
        
        }else{

            header("location:admin.php");

        }

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }
    

?>