<?php  

    session_start();


    require_once("classes/Messages.php");
    require_once("classes/status.php");
    require_once("models/config.php");
    require_once("models/Server.php");
    require_once("classes/Forms.php");
    require_once("models/Login.php");

     $login = new Login();
   
    if(isset($_SESSION["sistemaExamenes"]["user"])){
 
        $login -> user_type_verify($_SESSION["sistemaExamenes"]["userType"]);

    }else{

        
        $msg = "";

        $loginUser = "";

        if(isset($_POST['login'])){
           
            $loginUser = $login -> login($_POST['user'], $_POST['password'], $_POST['typeUser']);
            
            $msg = $loginUser["notice"];

        }

        require_once("views/theme/index_view.php");

    }
                            
?>