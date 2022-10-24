<?php  

class Evaluation extends Server{

	public function __construct(){

		parent::__construct();

		$this -> forms = new Forms();
    
    $this -> querySelect = "select * from evaluaciones"; 
		
	}

	public function get_one($idTest = ""){

        //obtener un examen en especifico

        if($this -> forms -> empty_data($idTest)){

            $search = $this -> search("select * examenes_realizados where exam_id='$idTest'", 
                                  "Error al seleccionar el examen<br>",
                                  "Busqueda exitosa",
                                  "No se encontraron datos del examen solicitado",
                                  "Error al buscar examen"
                                  );

            return $this -> status_query($search["status"], $search["notice"], $search["data"]);

        }else{

            return $this -> status_query("Error", "Faltan parametros", "Error");

        }

	}	


	public function get_all(){

		//obtener datos de todos los examenes

        $search = $this -> search("select * from examenes_realizados inner join examenes on exam_id=er_examen inner join configuracion_de_examen on configEx_examen=er_examen group by er_examen order by er_examen desc", 
                                  "Error al mostrar evaluaciones<br>",
                                  $this -> success_msg("Busqueda exitosa"),
                                  $this -> info_msg("No hay evaluciones realizadas"), 
                                  $this -> danger_msg("Error en la buqueda de evaluaciones"));



		return $this -> status_query($search["status"], $search["notice"], $search["data"]);

	}

  public function get_eval_table($data = ""){

        //tabla que contiene una lista con los examenes registrados y un link para verificar los alumnos que han 
        //realizado el examen seleccionado

        $tableIni = "<table class='table test-table  display' id='test-table'>";
        $tableEnd = "</tbody></table>";
        
        $headTable= "<thead><tr>
                        <th>Examen</th>
                        <th>Estado</th>
                        <th>Fecha de Aplicacion</th>
                    </tr></thead><tbody>";

        $tableBody = "";

        while($datos = mysqli_fetch_assoc($data)){
                                
            if($datos['exam_status']=='1'){
            
                $status='Activo';
            
            }else{
            
                $status='Inactivo';
            
            }
            
            $tableBody = $tableBody."<tr>
                    <td class='td-name text-left'>
                        <a href='alumnos_evaluados.php?examen=$datos[er_examen]' class='test-nameBtn' id='test-nameBtn' title='Click para ver los alumnos que han realizado este examen'>
                           <span class='fas fa-eye'></span>  $datos[exam_nombre] 
                        </a>
                    </td>
                    <td>
                       <span class='$status'>$status</span>
                    </td>
                    <td>
                        $datos[configEx_fechaDeAplicacion]
                    </td>
                    
                </tr>";
        
        }     

        return $tableIni.$headTable.$tableBody.$tableEnd;   

    }

    public function get_studentsBy_test($idTest = ""){

        //tabla qontiene los alumnos que han realizado el examen seleccionado
        
        $tableIni = "<table class='table test-table display' id='students-table'>";
        $tableBody = "";
        $tableEnd = "</tbody></table>";
        
        $headTable="<thead><tr>
                        <th>Alumno</th>
                        <th>Correctas</th>
                        <th>Incorrectas</th>
                        <th>Promedio</th>
                        <th>Borrar</th>
                    </tr></thead><tbody>";

        $idTest = $this -> data_cleaner($idTest);

        $search = $this -> search("Select * from examenes_realizados inner join examenes on  er_examen=exam_id inner join alumnos on er_alumno=alumnos.id inner join configuracion_de_examen on er_examen=configEx_examen where er_examen='$idTest'",
                                  "Error al buscar alumnos",
                                  $this -> success_msg("Busqueda de alumnos exitosa"),
                                  $this -> info_msg("No se encontraron resultados"),
                                  $this -> danger_msg("Error al buscar alumnos"));

        if($search["status"] == "done"){

            while($datos = mysqli_fetch_assoc($search["data"])){
                                    
                
                $tableBody = $tableBody."<tr>
                        <td class='td-name' id='td-name$datos[er_alumno]'>
                            $datos[apellido] $datos[nombre]
                        </td>
                        <td>
                            $datos[er_correctas]
                        </td>
                        <td>
                            $datos[er_incorrectas]
                        </td>
                        <td>
                            $datos[er_promedio]
                        </td>
                        <td>
                            <button class='btn del-studentBtn fas fa-trash-alt' id='del-studentBtn$datos[id]' value='$datos[er_examen]||$datos[er_alumno]' title='Click para borrar las notas del alumno y permitir que haga el examen nuevamente'>
                            </button>
                        </td>
                    </tr>";
            
            }     

        }else{

            $tableBody = "<tr><td>$search[notice]</td></tr>";

        }

        return $this -> status_query($search["status"], $search["notice"], $tableIni.$headTable.$tableBody.$tableEnd);   

    }

}

?>