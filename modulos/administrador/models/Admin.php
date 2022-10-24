<?php  

    class Admin extends Server{
        
        use status, Messages;

        public $usuario;
        public $nombre;
        public $password;

        public function __construct(){

            parent::__construct();
            
            $this -> forms = new Forms();

            $this -> querySelect = "select * from usuario";
            
            $this -> reset_form();

        }

        public function reset_form(){

            //datos de formulario
            $this -> usuario = "";
            $this -> nombre = "";
            $this -> password = "";

        }

        public function get_data_profile(){

            //obtener los datos de perfil del admin
            $getData = $this -> search("select * from usuarios",
                                       "Error al seleccionar datos de perfil",
                                       "Datos seleccionados correctamente",
                                       "Datos no encontrados",
                                       "Error al seleccionar los datos");

            if($getData["status"] == "done"){

                $data = $this -> status_query("done", 
                                              $getData["notice"],
                                              $getData["data"]);

            }else{

                $data = $this -> status_query($getData["status"],
                                              $getData["notice"],
                                              $getData["data"]);

            }

            return $data;
        
        }

        public function set_profile_data($idUser = "",
                                         $user = "", 
                                         $name = ""){

            //modificacion de datos de admin

            if($this -> forms -> empty_data($idUser) &&
               $this -> forms -> empty_data($user) && 
               $this -> forms -> empty_data($name)){

                $user = $this -> data_cleaner($user);
                $name = $this -> data_cleaner($name);
                $date = $this -> date;

                $update = $this -> crud("update usuarios set nombre = '$name', usuario = '$user', fechaDeActualizacion='$date'",
                                        "Error al actualizar informacion",
                                        "Informacion actualizada correctamente",
                                        "Error al actualizar informacion");

                return $this -> status_query($update["status"], $update["notice"], $update["data"]);

            }else{

                return $this -> status_query("error", "Faltan datos para actualizar","");

            }

        }

        public function set_admin_password($idUser = "",
                                           $password = "", 
                                           $confirmPass = ""){

            //modificacion de password de admin

            if($this -> forms -> empty_data($idUser) &&
               $this -> forms -> empty_data($password) && 
               $this -> forms -> empty_data($confirmPass)){

                $login = new Login();

                $passVerify = $login -> password_validity($password);

                if($passVerify["data"] != true){

                    return $this -> status_query("no-data", $passVerify["notice"]);

                }else if($password != $confirmPass){

                    return $this -> status_query("no-data",
                                                 "Su confirmacion de password es incorrecta", 
                                                 "");                  

                }else{

                    $password = $this -> data_cleaner($this -> crypt_data($password));
                    $confirmPass = $this -> data_cleaner($confirmPass);
                    $date = $this -> date;

                    $update = $this -> crud("update usuarios set password = '$password', fechaDeActualizacion='$date'",
                                            "Error al actualizar password",
                                            "Password actualizado correctamente",
                                            "Error al actualizar password");

                    return $this -> status_query($update["status"], 
                                                 $update["notice"], 
                                                 $update["data"]);                      

                }
                
            }else{

                return $this -> status_query("no-data", 
                                             "Faltan datos para actualizar",
                                             "");

            }

        }

        public function get_students_number(){

            //obtener el numero de estudiantes registrados
            $number = 0;

            $search = $this -> search("select count(id) as studentNumber from alumnos",
                                      "Error al contar alumnos",
                                      "Numero de alumnos obtenido exitosamente",
                                      "No se encontraron alumnos",
                                      "Error al contar alumnos");

            if($search["status"] == "done"){

                $number = mysqli_fetch_assoc($search["data"]);

                $number = $number["studentNumber"];

            }

            return $this -> status_query($search["status"], $search["notice"], $number);

        }

        public function get_test_number(){

          //obtener numero de examenes registrados

            $number = 0;

            $search = $this -> search("select count(exam_id) as testNumber from examenes",
                                      "Error al contar examenes",
                                      "Numero de examenes obtenido exitosamente",
                                      "No se encontraron examenes",
                                      "Error al contar examenes");

            if($search["status"] == "done"){
                
                $number = mysqli_fetch_assoc($search["data"]);

                $number = $number["testNumber"];

            }

            return $this -> status_query($search["status"], $search["notice"], $number);

        }

    }

?>