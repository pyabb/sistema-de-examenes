<?php  

	class Student extends Server{
		
		use status, Messages;

        public $nombre;
        public $apellidos;
        public $nacimiento;
        public $telefono;
        public $salon;
        public $matricula;
        public $materia;
        public $password;

		public function __construct(){

			parent::__construct();
            
			$this -> forms = new Forms();

            $this -> querySelect = "select * from alumnos";
			
            $this -> reset_form();

		}

        public function reset_form(){

            //datos de formulario
            $this -> usuario = "";
            $this -> nombre = "";
            $this -> apellidos = "";
            $this -> salon = "";
            $this -> matricula = "";
            $this -> materia = "";
            $this -> password = "";

        }

		public function set_status($id = "", $status = ""){

            //metodo para editar el estado del alumno
			
			 
			if($status == "1" || $status == "0"){

                $newStatus = "";

                switch($status){
                    
                    case"1";
                    
                        $newStatus = "0";
                    break;
                    case"0";

                        $newStatus = "1";

                    break;
                    default:

                        $newStatus = "error";

                    break;
                
                }

                if($newStatus == "error"){

                    return $this -> status_query("error", 
                                                          "Error en status", 
                                                          "0");

                }else{

                    $updateStatus = $this -> crud("update alumnos set estado = '$newStatus' where id = '$id'", 
                                              "Error al actualizar el estado", 
                                              "Status actualizado correctamente",
                                              "Error al actualizar el estado");

                    if($updateStatus["status"] == "done"){

                        return $this -> status_query($updateStatus["status"],
                                                     $updateStatus["notice"],
                                                     $newStatus);

                    }else{

                        return $this -> status_query($updateStatus["status"],
                                                     $updateStatus["notice"],
                                                     $newStatus);
                    }
                    
                }
            	

            }else{

                return $this -> status_query("error",
                                             "Status no reconocido",
                                             "0");

            }

		}

		public function get_one($idStudent = 0){

            //metodo para obtener datos de un alumno en particular

			$search = $this -> search($this -> querySelect." where alumnos.id='$idStudent'", 
                                      "Error al seleccionar alumno<br>");

			if($search["status"] == "done"){

				return $this -> status_query("done", "Busqueda exitosa", $search["data"]);

			}else{

				return $this -> swicth_status_query($search["status"], "", 
                                                    "No se encontraron datos del alumno", 
                                                    "Error al seleccionar el alumno"); 

			}

		}

		public function get_all(){

			//obtener datos de todos los alumnos

            $search = $this -> search($this -> querySelect." order by alumnos.nombre desc", 
                                      "Error al obtener datos de alumnos",
                                      "Datos obtenidos con exito",
                                      "No hay alumnos registrados",
                                      "Error al buscar alumnos");


			return $this -> status_query($search["status"], $search["notice"], $search["data"]);

		}

		public function get_by_name($name = ""){

            //obtener datos de alumnos por nombre

			if(!$this -> forms -> empty_data($name)){	
                
                return $this -> status_query("no-data", "Introdusca su busqueda", "vacio");

            }else{

                $busqueda = str_replace(' ', '|', $name);//reemplazar los espacios en blanco por | para usar la cadena en regexp

                $busqueda = $this -> data_cleaner($busqueda);
                $name = $this -> data_cleaner($name);
                
                $search = $this -> search($this -> querySelect." where (alumnos.nombre like '%$name%' or alumnos.apellido like '%$name%') or (alumnos.nombre regexp '$busqueda' && alumnos.apellido regexp '$busqueda') order by alumno desc", 
                                          'Error al obtener alumnos por nombre',
                                          "Mostrando resutados de su busqueda",
                                          "No se encontraron resultados",
                                          "Error al realizar la busqueda");

                if($search["status"] == "done"){


				}

                return $this -> status_query($search["status"], $search["notice"], $search["data"]);
            
            }

		}

        public function get_by_status($status = ""){

            //obtener alumnos por status

            if(!$this -> forms ->  empty_data($status)){    
                
                 return $this -> info_msg("No ha introducido ningun estado");
             
            }else{

                if($pagination == true){

                    $limit = "limit ".$this-> paginator-> inicio.", ".$this -> paginator -> limit;

                }else{

                    $limit = "";

                }     
           
                $search = $this -> search($this -> querySelect." where alumnos.estado='$status' order by alumno desc $limit", 'Error al mostrar alumnos por  estado');

                if($search["status"] == "done"){

                    return $this -> status_query("done", $this -> success_msg("Busqueda exitosa"), $search["data"]);

                }else{

                    return $this -> swicth_status_query($search["status"], "", $this -> info_msg("Sin datos que mostrar con el estado seleccionado"), $this -> danger_msg("Error al buscar alumnos por estado")); 

                }

            }

        }

		public function admin_student_table($data = ""){

            //Elaborar la tabla de alumnos para funciones de editar y borrar

            $iniTable = "<table class='table student-table display' id='admin-studentTable'>";
            $headTable = "<thead><tr>
                              <th>Usuario</th>
                              <th>Nombre</th>
                              <th class='text-center'>Estado</th>
                              <th class='text-center'>Password</th>
                              <th></th>
                         </tr></thead><tbody>";
            $bodyTable = "";
            $endTable = "</tbody></table>"; 

			while($datos = mysqli_fetch_assoc($data)){
                                                    
                if($datos['estado'] == '1'){
                
                    $status = 'Activo';
                
                }else{
                
                    $status = 'Inactivo';
                
                }
                
                $bodyTable = $bodyTable."<tr>
                        <td>
                            <span id='student-dataTd$datos[id]' class='student-dataTd$datos[id]'>$datos[usuario]</span>
                            <div class='set-formContainer' id='set-formContainer$datos[id]'></div>
                        </td>
                        <td>
                            <span class='student-dataTd$datos[id]'>$datos[apellido] $datos[nombre]</span>
                        </td>
                        <td class='text-center'>
                            <button class='update-statusBtn $status' id='update-statusBtn$datos[id]' value='$datos[id]||$datos[estado]' title='Click para actualizar estado'>
                                    
                                $status

                            </button>
                        </td>
                        <td class='text-center'>
                            <button class='reset-passBtn' id='reset-passBtn$datos[id]' value='$datos[id]' title='Click para resetear el password'>
                                    
                                Reset

                            </button>
                        </td>
                        <td class='text-center'>
                            
                            <button class='btn open-updateFormBtn  fas fa-pencil-alt' name='open-setStudent' id='open-setStudent' value='$datos[id]' title='Click para actualizar datos del alumno'>
                            </button>

                            <button class='btn del-studentBtn fas fa-trash-alt' id='del-studentBtn' value='$datos[id]' title='Click para borrar alumno'>
                            </button>

                        </td>
                    </tr>";
            
            }

            return $iniTable.$headTable.$bodyTable.$endTable;

		}

		public function add_one($data = ""){

            //registrar alumno
            $login = new Login();

			if(isset($data) && $this -> forms -> empty_data($data)){

                extract($data);

                $this -> usuario = $usuario;
                $this -> nombre = $nombre;
                $this -> apellidos = $apellidos;

                $passVerify = $login -> password_validity($password);
				
                if(!$this -> forms -> empty_data($usuario) || 
                   !$this -> forms -> empty_data($nombre) ||  
				   !$this -> forms -> empty_data($apellidos) ||
				   !$this -> forms -> empty_data($password) ||
                   !$this -> forms -> empty_data($passConfirm)){

                    $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
                }else if($passVerify["data"] != true ){

                    $msg = $this -> status_query("no-data", $this -> info_msg($passVerify["notice"]));

                }else if($password != $passConfirm){

                    $msg = $this -> status_query("no-data", 
                                                 $this -> info_msg("No coincide su confirmacion de password"));

                }else{

                    $usuario = $this -> data_cleaner($usuario);
                    $nombre = $this -> data_cleaner($nombre);
                    $apellido = $this -> data_cleaner($apellidos);
                    $password = $this -> data_cleaner($this -> crypt_data($password));
                    $estado = '1';
                    $userType = "alumn";
                    $date = $this -> date;

                    $search = $this -> search("select id from alumnos where usuario='$usuario'", 
                                              "Error al buscar usuario registrado",
                                              $this -> info_msg("El usuario que selecciono ya esta en uso"),
                                              $this -> success_msg("Usuario disponible"),
                                              $this -> danger_msg("Error al registrar alumno") 
                                              );
                    
                    if($search["status"] == "no-data"){

                    	   $addOne = $this -> crud("insert into alumnos (usuario, nombre, apellido, password, tipoUsuario, estado, fechaDeRegistro) values ('$usuario','$nombre','$apellido', '$password', '$userType','$estado', '$date')", 
                                                "Error al registrar alumno", 
                                                $this -> success_msg("El alumn@ &nbsp <strong>$nombre  $apellidos&nbsp</strong> se registro correctamente en la base de datos"),
                                                $this -> danger_msg("Error al registrar alumno"));

                        if($addOne["status"] == "done"){

                            $this -> reset_form();
    
                        }
                        
                        $msg = $this -> status_query($addOne["status"], $addOne["notice"], "");

                    }else{

                        $msg = $this -> status_query($search["status"], $search["notice"], "");
                
                    }

                     
                }

			}else{

				$msg = $this -> status_query("error", 
                                             $this -> danger_msg("Sin datos"));

			}

			return $msg;

		}

		public function get_add_form($msgForm = ""){

            //formulario para agregar alumnos

            return '<div class="form-wraper">

						<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="add-studentForm" id="add-studentForm" class="add-studentForm">
							
							  <!--<h2 class="form-header">Agregar alumno</h2>-->
													
							  <div class="msg-form" id="msg-form">'.$msgForm.'</div>
                        
                        	<div class="form-body row">

                                <div class="col-md-6">
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2">Usuario:</label>
                                        <div class="col-sm-10"> 
                                          <input type="text" name="usuario" id="usuario" class="form-control datos" tabindex="1" value="'.$this -> usuario.'">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2">Apellidos:</label>
                                        <div class="col-sm-10"> 
                                          <input type="text" name="apellidos" id="entrada" class="form-control datos" tabindex="3" value="'.$this -> apellidos.'">
                                        </div>
                                    </div>
                                    <div class="form-group row">  
                                        <label class="col-sm-2">Confirmar password:</label>
                                        <div class="col-sm-10"> 
                                            <input type="password" name="passConfirm" id="pass-confirm" class="form-control datos" tabindex="6">
                                        </div>
                                    </div>
                                   	
                                </div>

                                <div class="col-md-6">
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-2">Nombre:</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" name="nombre" id="nombre" class="form-control datos" tabindex="2" value="'.$this -> nombre.'">
                                        </div>
                                    </div>
                            	    <div class="form-group row">  
                                        <label class="col-sm-2">Password:</label>
                                        <div class="col-sm-10"> 
                                             <input type="password" name="password" id="password" class="form-control datos" tabindex="5">
                                        </div>
                                  </div>              
                                    
                                </div>
                                
                        	</div>

                        	<div class="footer-form">
                                    
                                 <input type="submit" name="add-student" value="Registrar" id="add-student" class="btn action-btn" tabindex="7">                                   
                            
                            </div><!--modal-footer-->

                        </form>    

                	</div>';

		}

		public function set_student($data = ""){

            //editar alumno

			extract($data);

			if(isset($data) && $this -> forms -> empty_data($data)){

				if(!$this -> forms -> empty_data($user) ||  
                   !$this -> forms -> empty_data($name) ||  
				   !$this -> forms -> empty_data($apellidos) ||
				   !$this -> forms -> empty_data($idStudent)){

                    $msg = $this -> status_operation("info", $this -> info_msg("Hay campos vacios"));
                
                }else{

                    $user = $this -> data_cleaner($user);
                    $name = $this -> data_cleaner($name);
                    $apellido = $this -> data_cleaner($apellidos);
                    $idStudent = $this -> data_cleaner($idStudent);
                    $date = $this -> date;
                    $data = "";

                    $setOne = $this -> crud("update alumnos set nombre='$name', apellido='$apellido', usuario='$user' where id='$idStudent'", 
                                            "Error al editar alumno",
                                            "Alumno/a  $name $apellido editado correctamente",
                                            "Error al editar alumnos");
                    
                    if($setOne["status"] == "done"){
                       
	                    $data = array("user" => $user,
                                      "name" => $name,
                                      "apellidos" => $apellidos);

                    }

                    $data = $this -> status_query($setOne["status"], $setOne["notice"], $data);                    
                    
                }

			}else{

				$data = $this -> status_query("warning", $this -> warning_msg("Sin datos"));;

			}

			return $data;

		}

        private function get_data_form_set($idStudent = ""){

            //obtener los datos para llenar el formulario de actualizacion de estudiante

            $getData = $this -> search("Select usuario, nombre, apellido from alumnos where id='$idStudent'",
                                        "Error al buscar datos del alumno",
                                        "Datos Obtenidos con exito",
                                        $this -> info_msg("No se encontraron datos"),
                                        $this -> danger_msg("Error al buscar datos del alumno"));

            $data = "vacio";

            if($getData["status"] == "done"){

                $data = mysqli_fetch_assoc($getData["data"]);

            }

            return $this -> status_query($getData["status"], $getData["notice"], $data);

        }

		public function get_set_form($idStudent = ""){
			
            //muestra el formulario para editar alumno
            
            if(!$this -> forms -> empty_data($idStudent)){

              return $this -> status_query("no-data", 
                                           $this -> info_msg("Faltan datos del alumno para mostrar el formulario"), 
                                           "vacio");
            
            }else{

                $getData = $this -> get_data_form_set($idStudent);

                $user = "";
                $name = "";
                $apellidos = "";

                if($getData["status"] == "done"){
                  
                    $user = $getData["data"]["usuario"];
                    $name = $getData["data"]["nombre"];
                    $apellidos = $getData["data"]["apellido"];

                    return $this -> status_query("done", "Mostrando formulario", '<div class="set-formWrap col-xs-12 col-sm-12 col-md-6" id="set-formWrap">

                            <form action="'.$_SERVER['PHP_SELF'].'" method="post" name="set-studentForm" id="set-studentForm" class="set-studentForm">
                                
                                <h2 class="title-form">Editar Datos</h2>

                                <div class="change-dataMsg" id="chnage-dataMsg"></div>
                            
                                <div class="form-body">

                                    <div class="form-group row">
                                        <label class="label-data col-sm-2">Usuario:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="user" id="user" class="dataSet form-control" tabindex="1" value="'.$user.'">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="label-data col-sm-2">Nombre:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" id="name" class="dataSet form-control" tabindex="2" value="'.$name.'">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="label-data col-sm-2">Apellidos:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="apellidos" id="apellidos" class="dataSet form-control" tabindex="3" value="'.$apellidos.'">
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="footer-form">
                     
                                    <div class="form-group row footer-formRow">
                                        <div class="col-sm-12 foot-col-row">   
                                            <input type="submit" name="set-student" value="Editar" id="set-student" class="btn action-btn" tabindex="4">
                                        </div>
                                    </div>
                               
                                </div>

                            </form>

                        </div>'); 

                }else{

                    return $this -> status_query($getData["status"], $getData["notice"], $getData["notice"]);

                }

            }

		}

        public function del_student($idStudent = ""){

            //borrar alumno

            $data = "";

            if($this -> forms -> empty_data($idStudent)){

                    $idStudent = $this -> data_cleaner($idStudent);

                    $delStudent = $this -> crud("delete from alumnos where id='$idStudent'", 
                                                "Error al eliminar  estudiante",
                                                "Alumno eliminado correctamente",
                                                "Error al eliminar el alumno");

                    $delEr = $this -> crud("delete from examenes_realizados where er_alumno='$idStudent'", 
                                                "Error al eliminar examenes realizados",
                                                "Examenes realizados eliminados correctamente",
                                                "Error al eliminar examenes realizados");



                    $data = $this -> status_query($delStudent["status"], 
                                                 $delStudent["notice"]);

                    
            }else{

                $data = $this -> status_query("no-data", $this -> info_msg("No se recibieron datos suficientes para eliminar el alumno"));

            }

            return $data;

        }

        public function reset_password($idStudent = ""){

            //resetear password

            $data = "";

            if($this -> forms -> empty_data($idStudent)){

                    $idStudent = $this -> data_cleaner($idStudent);
                    $password = $this -> crypt_data("12345");

                    $resetPass = $this -> crud("update  alumnos set password='$password' where id='$idStudent'", 
                                                "Error al resetear password",
                                                "Password reseteado correctamente",
                                                "Error al resetear password");

                    $data = $this -> status_query($resetPass["status"], 
                                                 $resetPass["notice"],
                                                 $resetPass["data"]);

                    
            }else{

                $data = $this -> status_query("no data", $this -> info_msg("No se recibieron datos suficientes para resetear el password del alumno"));

            }

            return $data;

        }

        public function set_profile_data($user = "", 
                                         $name = "", 
                                         $apellidos = "",
                                         $studentId){

            //actualizar datos del alumno

            if($this -> forms -> empty_data($studentId) &&
               $this -> forms -> empty_data($user) && 
               $this -> forms -> empty_data($name) &&
               $this -> forms -> empty_data($apellidos)){

                $user = $this -> data_cleaner($user);
                $name = $this -> data_cleaner($name);
                $apellidos = $this -> data_cleaner($apellidos);
                $date = $this -> date;

                $update = $this -> crud("update alumnos set nombre = '$name', usuario = '$user', apellido='$apellidos', fechaDeActualizacion='$date' where id='$studentId'",
                                        "Error al actualizar informacion",
                                        "Informacion actualizada correctamente",
                                        "Error al actualizar informacion");

                return $this -> status_query($update["status"], $update["notice"], $update["data"]);

            }else{

                return $this -> status_query("error", "Faltan datos para actualizar","");

            }

        }

        public function set_student_password($studentId = "",
                                             $password = "", 
                                             $confirmPass = ""){

            //resetear password del alumno
            
            if($this -> forms -> empty_data($studentId) ||
               $this -> forms -> empty_data($password) || 
               $this -> forms -> empty_data($confirmPass)){

                $login = new Login();

                $passVerify = $login -> password_validity($password);

                if($passVerify["data"] != true){

                    return $this -> status_query("no-data", $passVerify["notice"]);

                }else if($password == $confirmPass){

                    $password = $this -> data_cleaner($this -> crypt_data($password));
                    $date = $this -> date;

                    $update = $this -> crud("update alumnos set password = '$password', fechaDeActualizacion='$date' where id='$studentId'",
                                            "Error al actualizar password",
                                            "Password actualizado correctamente",
                                            "Error al actualizar password");

                    return $this -> status_query($update["status"], 
                                                 $update["notice"], 
                                                 $update["data"]);

                }else{

                    return $this -> status_query("no-data", 
                                                 "Su confirmacion de password es incorrecta", 
                                                 "");                    
                }
                
            }else{

                return $this -> status_query("error", 
                                             "Faltan datos para actualizar",
                                             "");

            }

        }

	}//fin de clase

?>