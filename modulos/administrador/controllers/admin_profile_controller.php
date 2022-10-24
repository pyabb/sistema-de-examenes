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

        $admin = new Admin();

        //username contiene el nombre que apareve en la barra de menu
        $userName = $_SESSION["sistemaExamenes"]["name"];

        $user = '';

        $name = '';

        $typeUser = '';

        $data = "";

        $msg = "";

        $getData = $admin -> get_data_profile();

        if($getData['status'] === 'done'){

            $data = mysqli_fetch_assoc($getData["data"]);
            
            //datos que se cargaran en el formulario

            $user = $data["usuario"];
        
            $name = $data["nombre"];

            $typeUser = $data["tipoUsuario"];    
        
        }else{

            //en caso de error o no encontrar los datos del usuario entra aqui

            $msg = Messages::status_notice($getData['status'], $getData['notice']);
 
        }
        
        //cargar vista
        require_once("modulos/administrador/views/theme/admin_profile_view.php");  

    }else{

        echo "Solo pueden acceder usuarios logeados <a href='index.php'>Login</a>";

    }


?>