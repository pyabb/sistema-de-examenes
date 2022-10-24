<?php  

class Test extends Server{

    public function __construct(){

    		parent::__construct();

    		$this -> forms = new Forms();

        $this -> eval = new Evaluation();

    		$this -> paginator = null;

        $this -> querySelect = "select * from examenes"; 
  		
  	}

  	public function get_one($idTest = ""){

        //obtener un examen en especifico

        if($this -> forms -> empty_data($idTest)){

            $search = $this -> search($this -> querySelect." where exam_id='$idTest'", 
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

        $search = $this -> search($this -> querySelect." left join configuracion_de_examen on configEx_examen=exam_id order by exam_nombre desc", 
                                    "Error al mostrar los examenes<br>",
                                    "Busqueda exitosa",
                                    "No se encontraron coincidencias con su busqueda", 
                                    "Error en la buqueda de examenes");



  		  return $this -> status_query($search["status"], $search["notice"], $search["data"]);

  	}

    public function get_questions_number($idTest = ""){

        $getQuestions = $this -> search("select count(preg_id) as questionsNumber from preguntas where preg_examen = '$idTest'",
                                        "Error al contar preguntas");

        $number = 0;

        if($getQuestions["status"] == "done"){

            $data = mysqli_fetch_assoc($getQuestions["data"]);

            $number = $data["questionsNumber"];

        }

        return $this -> status_query($getQuestions["status"], $getQuestions["notice"], $number);

    }

    public function show_test(){

        $search = $this -> get_all();

        if($search["status"] == "done"){

            return  $this -> get_table($search["data"]);

        }else{

            if($search["status"] == "no-data"){

                return $this -> info_msg("No ha registrado examenes");

            }else{

               return $this -> danger_msg("Error al buscar examenes registrados");

            }
            
        }

    }


    /*****preguntas*****/

    public function get_question($idTest = "", 
                                 $idQuestion = ""){

        $searchQ = $this -> search("select preg_id, preg_pregunta from preguntas where preg_examen='$idTest' and preg_id='$idQuestion'",
                                  "Error al obtener en bd al obtener la pregunta seleccionada", 
                                  "Pregnta obtenida con exito", 
                                  "No se encontro la pregunta seleccionada", 
                                  "Error al obtener la pregunta seleccionada");

        return $this -> status_query($searchQ["status"], $searchQ["notice"], $searchQ["data"]);

    }

    public function get_questions($idTest = "", $limit = "", $pageIni = ""){

        if($limit != "" && $pageIni != ""){$pageIni = "limit ".$pageIni.", ";}
        if($limit != "" && $pageIni == ""){$pageIni = "limit ".$pageIni;}
        
        $searchQ = $this -> search("select preg_id, preg_pregunta from preguntas where preg_examen='$idTest' order by preg_id asc $pageIni $limit",
                                  "Error al obtener las preguntas del examen", 
                                  $this -> success_msg("Pregntas obtenidas con exito"), 
                                  $this -> info_msg("No se encontraron preguntas para este examen"), 
                                  $this -> danger_msg("Error al obtener las preguntas del examen"));

        return $this -> status_query($searchQ["status"], $searchQ["notice"], $searchQ["data"]);

    }

    public function get_questions_list($idTest = "", $limit = "", $pageIni = ""){

        //obtener lista de preguntas de examen

        $questionsList = "";
        $answers = "";
        
        if($pageIni != ""){
          $startAttr = $pageIni + 1;
        }else{
          $startAttr = 0 + 1;
        }

        $olStart = "<ol class='list-questions' start='$startAttr' id='questions-list'>";
        $olEnd = "</ol>";
        
        $getQuestions = $this -> get_questions($idTest, $limit, $pageIni);

        if($getQuestions["status"] == "done"){

            while($row = mysqli_fetch_assoc($getQuestions["data"])){

              $answers = $this -> get_answers_list($row["preg_id"], $idTest);
                
                if($answers != false){
                
                  $questionsList = $questionsList."<li class='question-itemWrap'><span class='question-item' id='question-item$row[preg_id]'>$row[preg_pregunta]</span> 
                          <ul id='answers-wrap'>".
                            $answers  
                          ."</ul>
                      </li>";

                }else{

                    $getQuestions["status"] = "no-data";
                    $getQuestions["notice"] = $this -> info_msg("Hay una pregunta o preguntas que no tienen respuesta correcta, favor de verificar.");
                
                }
            
            }

        }

        return $this -> status_query($getQuestions["status"],
                                     $getQuestions["notice"], 
                                     $olStart.$questionsList.$olEnd);

    }

    public function get_questions_qualified($idTest = "", $userAnswers = ""){

        //obtener lista de preguntas de examen

        $questionsList = "";
        $answers = "";
        $olStart = "<ol class='list-questions'>";
        $olEnd = "</ol>";
        $class = "";
        $correctNumber = 0;
        
        $getQuestions = $this -> get_questions($idTest);

        if($getQuestions["status"] = "done"){

            while($row = mysqli_fetch_assoc($getQuestions["data"])){

              $answers = $this -> get_answers_qualified($row["preg_id"], $idTest, $userAnswers);

                if($answers["itsCorrect"]){

                  $class = "fas fa-check its-correct";
                  $correctNumber++;

                }else{

                  $class = "fas fa-times its-incorrect";

                }
              
                $questionsList = $questionsList."<li>
                                                  <div class='question-wrap'>
                                                      <span class='' id='question-item'>$row[preg_pregunta]</span>
                                                      <span class='$class'></span> 
                                                 </div>
                                                <ul id='answers-wrap'>".
                                                  $answers["answers"]  
                                                ."</ul>
                                            </li>";
              
            }

        }

        return $this -> status_query($getQuestions["status"],
                                     $getQuestions["notice"], 
                                     array("questions" => $olStart.$questionsList.$olEnd, 
                                           "correctQuestions" => $correctNumber));

    }

    public function write_questions($data = "", 
                                    $idTest = ""){

        $questions = "";
        $answers = "";

        while($row = mysqli_fetch_assoc($data)){

            $answers = $this -> load_answers($row["preg_id"], $idTest);

            $questions = $questions.$this -> format_question($row["preg_pregunta"], 
                                                             $row["preg_id"], 
                                                             $answers);

        }

        return $questions;
        
    }

    public function format_question($question = "",
                                    $idQuestion = "", 
                                    $answers = ""){

        return "<li><span class='' id='question-item$idQuestion'>$question</span> 
                    <button id='update-questionBtn' class='btn update-btn update-questionBtn fas fa-pencil-alt' value='$idQuestion' title='Click para editar la pregunta'>
                    </button>
                    <button id='del-question' class='btn del-btn del-questionBtn fas fa-trash-alt' data-toggle='modal' data-target='del-testModal' value='$idQuestion' title='Click para borrar la pregunta'>
                    </button>
                    <button id='add-answer' class='btn add-btn add-answerBtn fas fa-plus-circle' value='$idQuestion' title='Click para agregar respuestas a la pregunta'>
                    </button>
                    <div id='addAnswerFormWrap$idQuestion' class='add-answerFormWrap'></div>
                    <ul id='answers-wrap$idQuestion'>".
                      $answers  
                    ."</ul>
                </li>";

    }


    /****respuestas*****/

    public function get_answer($idTest = "", 
                               $idQuestion = "",
                               $idAnswer = ""){

        $search = $this -> search("select resp_id, resp_texto from respuestas where resp_examen='$idTest' and resp_pregunta='$idQuestion' and resp_id='$idAnswer'",
                                  "Error al obtener en bd al obtener la respuesta seleccionada", 
                                  "Respuesta obtenida con exito", 
                                  "No se encontro la respuesta seleccionada", 
                                  "Error al obtener la respuesta seleccionada");

        return $this -> status_query($search["status"], $search["notice"], $search["data"]);

    }

    public function get_answers_list($idQuestion = "", 
                                     $idTest = ""){

        //respuestas del examen a realizar

        $searchAns = $this -> search("select * from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest'",
                                     "Error al seleccionar las respuestas", 
                                     $this -> success_msg("Mostrando respuestas"), 
                                     $this -> info_msg("No hay respuestas registradas para esta pregunta"),
                                     $this -> danger_msg("Error al cargar las respuestas"));
        $answer = "";

        if($searchAns["status"] == "done"){

           //buscar numero de respuestas correctas
            $searchNumAns = $this -> search("select resp_id from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest' and resp_correcta='1'",
                                     "Error al seleccionar las respuestas correctas", 
                                     $this -> success_msg("Mostrando respuestas correctas"), 
                                     $this -> info_msg("No hay respuestas registradas para esta pregunta"),
                                     $this -> danger_msg("Error al cargar las respuestas"));

            $numCorrect = 0;

            if($searchNumAns["status"] == "done"){

              $numCorrect = mysqli_num_rows($searchNumAns["data"]);
  
            }
            
            $typeInput = "";

            while ($row = mysqli_fetch_assoc($searchAns["data"])){

              if($numCorrect == 0){

                $answer = false;

              }else{

                if($numCorrect > 1){

                    //si hay mas de una respuesta correcta utilizamos el control checkbox. en el atributo name se utiliza el id de la pregunta y el id de la respuesta que seran utilizados para identificar la respuesta a la hora de revisarlas     
                    
                    $typeInput = "<input type='checkBox' name='$idQuestion$row[resp_id]' id='answerCheckBox$row[resp_id]' class='check-boxAnswer' value='$row[resp_id]' title='Click para marcar la respuesta correcta'>";
                  
                }else{

                    //si la pregunta tiene una sola respuesta se utiliza el control radio y se utiliza en el atributo name solo el id de pregunta

                    $typeInput = "<input type='radio' name='$idQuestion' id='answerCheckBox$row[resp_id]' class='check-boxAnswer' value='$row[resp_id]' title='Click para marcar la respuesta correcta'>";
                  
                }

                $answer = $answer."<li>
                                        $typeInput
                                        <span id='answer-item$row[resp_id]' class=''>$row[resp_texto]</span>
                                        
                                   </li>";

              }
                                                    
            }                                    

            return $answer;

        }else{

            return $searchAns["notice"];
                                    
        }
        
    }

    public function get_answers_qualified($idQuestion = "", 
                                          $idTest = "",
                                          $userAnswers = ""){

        //$userAnswers array que contiene las respuestas del usuario 

        //respuestas del examen a realizar

        $searchAns = $this -> search("select * from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest'",
                                     "Error al seleccionar las respuestas", 
                                     $this -> success_msg("Mostrando respuestas"), 
                                     $this -> info_msg("No hay respuestas registradas para esta pregunta"),
                                     $this -> danger_msg("Error al cargar las respuestas"));
        $answer = "";

        if($searchAns["status"] == "done"){

            $searchNumAns = $this -> search("select resp_id from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest' and resp_correcta='1'",
                                     "Error al seleccionar las respuestas correctas", 
                                     $this -> success_msg("Mostrando respuestas correctas"), 
                                     $this -> info_msg("No hay respuestas registradas para esta pregunta"),
                                     $this -> danger_msg("Error al cargar las respuestas"));

            $numCorrect = 0;

            if($searchNumAns["status"] == "done"){

              $numCorrect = mysqli_num_rows($searchNumAns["data"]);
  
            }
            
            $typeInput = "";
            $class = "";
            $correctAns = 0;
            $a="";
          
            while ($row = mysqli_fetch_assoc($searchAns["data"])){

              /*si existe la respuesta en el array de respuestas enviadas se verifica. los indices del array de respuestas del usuario
              contienen el id de pregunta o el id de pregunta y el id de respuesta seguna sea el caso de una o dos respuestas*/ 
              
              if(isset($userAnswers[$row["resp_pregunta"]]) || 
                 isset($userAnswers[$row["resp_pregunta"].$row["resp_id"]])){

                  if(isset($userAnswers[$row["resp_pregunta"]]) && $userAnswers[$row["resp_pregunta"]] == $row["resp_id"] ||
                    isset($userAnswers[$row["resp_pregunta"].$row["resp_id"]]) && $userAnswers[$row["resp_pregunta"].$row["resp_id"]] == $row["resp_id"]){

                      //verificar si la respuesta del usuario es correcta 
                    
                      if($row["resp_correcta"] == "1"){

                          $class = "Activo";
                          $correctAns++;
                      
                      }else{

                          $class ="Inactivo";

                      }
  
                  }else{

                    $class = "";

                  }
                  
              }else{

                $class = "";
              
              }

                $answer = $answer."<li>
                                       
                                        <span id='answer-item$row[resp_id]' class='$class'>$row[resp_texto]</span> 
                                        
                                   </li>";
                                                    
            }

            $itsCorrect = false;

            if($correctAns == $numCorrect){

              $itsCorrect = true;

            }                                    

            return array("answers" => $answer, "itsCorrect" => $itsCorrect);

        }else{

            array("answers" => $searchAns["notice"], "itsCorrect" => false);
                                    
        }
        
    }

    public function get_correct_answers($idTest = ""){

        $getAns = $this -> search("select * from respuestas where resp_examen = '$idTest' and resp_correcta = '1'",
                                  "Error buscar respuestas correctas",
                                  "Mostrando respuestas correctas",
                                  "No se encontraron respuestas correctas para este examen",
                                  "Error al buscar respuestas correctas");

        return $this -> status_query($getAns["status"], $getAns["notice"], $getAns["data"]);

    }

    public function load_answers($idQuestion = "", 
                                $idTest = ""){

        $searchAns = $this -> search("select * from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest'",
                                     "Error al seleccionar las respuestas", 
                                     "Mostrando respuestas", 
                                     $this -> info_msg("No hay respuestas registradas para esta pregunta"),
                                     $this -> danger_msg("Error al cargar las respuestas"));
        $answer = "";

        if($searchAns["status"] == "done"){

            $class = "";
            $chequed = "";

            while ($row = mysqli_fetch_assoc($searchAns["data"])){

              if($row["resp_correcta"] == "1"){

                $class = "correct-answer";
                $chequed = "checked";

              }else{

                $class = "normal-answer";
                $chequed = "";
              
              }

                $answer = $answer."<li>
                                        <input type='checkBox' $chequed name='answer$row[resp_id]' id='answerCheckBox$row[resp_id]' class='check-boxAnswer' value='$row[resp_id]||$idQuestion||$row[resp_correcta]' title='Click para marcar la respuesta correcta'>
                                        <span id='answer-item$row[resp_id]' class='$class'>$row[resp_texto]</span>
                                        <button class='btn update-btn update-answerBtn fas fa-pencil-alt' value='$row[resp_id]||$idQuestion' title='Click para editar la respuesta'>
                                        </button>
                                        <button class='btn del-btn del-answerBtn fas fa-trash-alt' value='$row[resp_id]||$idQuestion' title='Click para borrar la respuesta'>
                                        </button>
                                   </li>";
                                                    
            }                                    

            return $answer;

        }else{

            return $searchAns["notice"];
                                    
        }
        
    }
    

    /****examenes*****/
    public function get_data_expire($idTest = ""){

        $search = $this -> search("select *, exam_status from configuracion_de_examen inner join examenes on exam_id=configEx_examen where configEx_examen='$idTest'",
                                  "Error al obtener datos de expiracion",
                                  "Tiempo de expiracion obtenido exitosamente",
                                  "No hay datos",
                                  "Error al obtener datos de expiracion");

        return $this -> status_query($search["status"], $search["notice"], $search["data"]);  

    }

    public function get_test_name($idTest = ""){

        //datos del examen
        $testName = "";
 
        $search = $this -> search("select exam_nombre from examenes where exam_id='$idTest'", 
                                   "Error al obtener el nombre del examen",
                                   "Nombre del examen obtenidos con exito",
                                   "No se encontro el nombre del examen solicitado",
                                   "Error al obtener el nombre del examen");

        if($search["status"] == "done"){

            $dataTest = mysqli_fetch_assoc($search["data"]);

            $testName = $dataTest["exam_nombre"];
    
        }else{

            $testName = $search["notice"];
        
        }

        return $this -> status_query($search["status"], 
                                     $search["notice"], 
                                     $testName);

    }

    public function get_instructions($idTest = ""){

        $search = $this -> search("select exam_instrucciones from examenes where exam_id='$idTest'",
                                  "Error al obtener las instrucciones del examen", 
                                  "Instrucciones obtenidas con exito", 
                                  "No se encontraron instrucciones para este examen", 
                                  "Error al obtener las instrucciones del examen");

        if($search["status"] == "done"){

          $instructions = mysqli_fetch_assoc($search["data"]);

          $instructions = $instructions["exam_instrucciones"]; 

        }else{

          $instructions = $search["notice"];

        }

        return $this -> status_query($search["status"], $search["notice"], $instructions);

    }

    public function get_test_data($idTest = ''){

        //datos del examen
        $testName = "";
        $instructions = "";
        $promMin = 0;

        $search = $this -> search("select * from examenes inner join configuracion_de_examen on configEx_examen=exam_id where exam_id='$idTest'", 
                                   "Error al cargar datos del examen",
                                   $this -> success_msg("Datos del examen obtenidos con exito"),
                                   $this -> info_msg("No se encontraron los datos del examen solicitado"),
                                   $this -> danger_msg("Error al obtener los datos del examen"));

        if($search["status"] == "done"){

            $dataTest = mysqli_fetch_assoc($search["data"]);

            $testName = $dataTest["exam_nombre"];
            $instructions = "<strong>Instrucciones:</strong>"."<span id='inst-container'>".$dataTest["exam_instrucciones"]."</span></p>";
            $promMin = $dataTest["configEx_promMin"];

        }else{

          $testName = $search["notice"];
          $instructions = $search["notice"];
          $promMin = $search["notice"];
        
        }

        return $this -> status_query($search["status"], 
                                     $search["notice"], 
                                     array("testName" => $testName, 
                                           "instructions" => $instructions,
                                           "promMin" => $promMin));

    }

    public function get_data_test($idTest = ""){

        //instrucciones
        $searchIns = $this -> search("select * from examenes where exam_id='$idTest'", 
                                   "Error al cargar las intrucciones",
                                   "Datos del examen obtenidos con exito",
                                   "No se encontraron los datos del examen solicitado",
                                   "Error al obtener los datos del examen");

        if($searchIns["status"] == "done"){

            $instructions = mysqli_fetch_assoc($searchIns["data"]);

            $instructions = $instructions["exam_instrucciones"];

            $instructions = "<p><strong>Instrucciones:</strong> <span id='inst-container'>".$instructions."</span></p>";

        }
        
        //preguntas

        $questions = "";

        $getQuestions =  $this -> get_questions($idTest);

        if($getQuestions["status"] == "done"){

            $questions = $this -> write_questions($getQuestions["data"],
                                         $idTest);

        }else{

            $questions = $getQuestions["notice"];
        
        }

        return $this -> status_query($searchIns["status"].$getQuestions["status"], 
                                     $searchIns["notice"].$getQuestions["notice"], 
                                     array("instructions" => $instructions, "questions" => $questions)); 

    }

    public function get_config_testData($idTest = ""){

        $data = array("hour" => "", "date" => "", "limitTime" => "");

        $search = $this -> search("select * from configuracion_de_examen where configEx_examen='$idTest'",
                                  "Error al obtener la configuracion del examen", 
                                  "Configuracion obtenida con exito", 
                                  "Configuracion no encontrada para este examen", 
                                  "Error al obtener la configuracion del examen");

        if($search["status"] == "done"){

          $testData = mysqli_fetch_assoc($search["data"]);

          $data = array("hourAp" =>  $testData["configEx_horaDeAplicacion"],
                        "dateAp" =>  $testData["configEx_fechaDeAplicacion"],
                        "hourEx" =>  $testData["configEx_horaDeExpiracion"], 
                        "dateEx" =>  $testData["configEx_fechaDeExpiracion"],
                        "promMin" =>  $testData["configEx_promMin"]);          

        }

        return $this -> status_query($search["status"], $search["notice"], $data);

    }

    
    /****tablas*****/
    public function get_table($data = ""){

        //tabla con lista de examenes registrados 
        $tableIni = "<table class='table test-table' id='test-table'>";
        $tableEnd = "</tbody></table>";
        
        $headTable="<thead><tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Configuracion</th>
                        <th>Fecha / hora de aplicacion</th>
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
                        <a href='escribir_examen.php?examen=$datos[exam_id]' class='test-nameBtn' id='test-name$datos[exam_id]' title='Click para registrar preguntas del examen'>
                          $datos[exam_nombre] 
                        </a>
                        <span class='fas fa-pencil-alt'></span>
                        <div>
                          <button class='btn update-testBtn fas fa-pencil-alt' value='$datos[exam_id]' title='Click para editar nombre'>
                          </button>
                          <button class='btn del-testBtn fas fa-trash-alt' value='$datos[exam_id]' title='Click para borrar el examen'>
                          </button>
                        </div>
                        <div id='up-containerForm$datos[exam_id]' class='up-containerForm'></div>
                    </td>
                    <td>
                        <button class='status-btn $status' id='status-btn$datos[exam_id]' value='$datos[exam_id]||$datos[exam_status]' title='Click para actualizar estado'>$status</button>
                    </td>
                    <td>
                        <button class='btn config-testBtn fas fa-cog' value='$datos[exam_id]' title='Click para configurar el examen'>
                          </button>
                    </td>
                    <td>
                        <span id='test-dateApli$datos[exam_id]'>$datos[configEx_fechaDeAplicacion] / $datos[configEx_horaDeAplicacion]</span>
                    </td>
                
                </tr>";
        
        }     

        return $tableIni.$headTable.$tableBody.$tableEnd;   

    }

    
    /*formularios*/

    public function get_update_testForm($testName = ''){

        return  "<div  class='update-testWrap' id='update-testWrap'>
                        
                        <!--examen-->
                        <form action='' method='post' name='update-testForm' id='update-testForm' class='update-testForm'>
                        
                            <div class='wrap-control'>
                              <label>Nombre de examen:</label>
                              <input name='testName' class='dataTestTxt' id='upTestName' placeholder='Escriba el nombre del examen' value='$testName'>
                            </div>
                            <div class='footer-form'>
                                <button type='submit' name='up-testBtn' class='btn up-testBtn' id='updateTestBtn'>
                                    Guardar
                                </button>
                            </div>
                        </form>

                    </div>";  

    }

    public function get_update_questionForm($question = ""){

        return  "<div  class='update-questionWrap' id='update-questionWrap'>
                        
                        <!--pregunta-->
                        <form action='' method='post' name='updateAnswerForm' id='idAnswerForm' class='update-answerForm'>
                        
                            <label>Editar Pregunta:</label>
                            <textarea name='questionTxt' class='data-question' id='upQuestionTxt'>$question</textarea>
                            <div class='footer-form'>
                                <button type='submit' name='updateQuestionBtn' class='btn update-questionBtn' id='updateQuestionBtn'>
                                    Guardar
                                </button>
                            </div>
                        </form>

                    </div>";  

    }

    public function get_add_answerForm($idQuestion = ""){

        return  "<div  class='add-answerWrap' id='add-answerWrap'>
                        
                        <!--respuestas-->
                        <form action='' method='post' name='addAnswerForm' id='idAnswerForm' class='add-answerForm'>
                        
                            <label>Agregar Respuesta:</label>
                            <textarea name='answerTxt' class='data-answer' id='answerTxt'></textarea>
                            <div class='footer-form'>
                                <button type='submit' name='addAnwserBtn' class='btn add-anwserBtn' id='addAnwserBtn'>
                                    Guardar
                                </button>
                            </div>
                        </form>

                    </div>";  

    }

    public function get_update_answerForm($answer = ""){

        return  "<div  class='update-answerWrap' id='update-answerWrap'>
                        
                        <!--respuestas-->
                        <form action='' method='post' name='updateAnswerForm' id='idAnswerForm' class='update-answerForm'>
                        
                            <label>Editar Respuesta:</label>
                            <textarea name='answerTxt' class='data-answer' id='upAnswerTxt'>$answer</textarea>
                            <div class='footer-form'>
                                <button type='submit' name='updateAnwserBtn' class='btn update-anwserBtn' id='updateAnswerBtn'>
                                    Guardar
                                </button>
                            </div>
                        </form>

                    </div>";  

    }


    /*****actualizar*****/
    
    public function set_test_name($testName = "",
                                 $idTest = ""){

            //actualizar pregunta

        if(!$this -> forms -> empty_data($testName) ||  
           !$this -> forms -> empty_data($idTest)){

                    $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
                }else{

                    $testName = $this -> data_cleaner(rtrim($testName));
                    $idTest = $this -> data_cleaner($idTest);
                    
                    $setName = $this -> crud("update examenes set exam_nombre='$testName', exam_fechaActualizar='".$this -> date."' where exam_id='$idTest'", 
                                            "Error al editar examen",
                                            "Examen editado correctamente",
                                            "Error al editar examen");
                    
                    $name = "";

                    if($setName["status"] == "done"){

                        $name = $testName;

                    }else{

                        $name = $setName["notice"];

                    }      

                    $msg = $this -> status_query($setName["status"], 
                                                 $setName["notice"],
                                                 $name);
                }//verificar campos vacios

      return $msg;

    }

    public function set_test_config($hourAp = "",
                                    $dateAp = "",
                                    $hourEx = "",
                                    $dateEx = "",
                                    $promMin = "",  
                                    $idTest = ""){

        //configurar examen

        if(!$this -> forms -> empty_data($idTest)){

                    $data = $this -> status_query("no-data", "Hay campos vacios");
                
                }else{

                    $idTest = $this -> data_cleaner($idTest);
                    $hourAp = $this -> data_cleaner($hourAp);
                    $dateAp = $this -> data_cleaner($dateAp);
                    $hourEx = $this -> data_cleaner($hourEx);
                    $dateEx = $this -> data_cleaner($dateEx);
                    $promMin = $this -> data_cleaner($promMin);
                    $config = false;
                    
                    $search = $this -> search("select configEx_id from configuracion_de_examen where configEx_examen='$idTest'", 
                                            "Error al buscar examen",
                                            "Examen encontrado",
                                            "Examen no encontrado",
                                            "Error al buscar examen");
                    
                    if($search["status"] == "done"){

                      $config = $this -> crud("update configuracion_de_examen set configEx_horaDeAplicacion='$hourAp', configEx_fechaDeAplicacion='$dateAp', configEx_horaDeExpiracion='$hourEx', configEx_fechaDeExpiracion='$dateEx', configEx_promMin='$promMin' where configEx_examen='$idTest'", 
                                            "Error al editar examen",
                                            "Examen configurado correctamente",
                                            "Error al editar examen");
                    
                    
                    }else if ($search["status"] == "no-data"){

                      $config = $this -> crud("insert into configuracion_de_examen (configEx_examen, configEx_horaDeAplicacion, configEx_fechaDeAplicacion, configEx_horaDeExpiracion, configEx_fechaDeExpiracion) values ('$idTest','$hourAp','$dateAp','$hourEx','$dateEx')", 
                                            "Error al registrar configuracion del examen",
                                            "Examen configurado correctamente",
                                            "Error al registrar configuracion del examen");
                    

                    }else{

                      $config["status"] = "error";
                      $config["notice"] = "Error al buscar configuracion";

                    }
                    
                    $data = $this -> status_query($config["status"], 
                                                 $config["notice"],
                                                 "");
                
                }//verificar campos vacios

      return $data;

    } 

    public function set_status_test($status = "",
                                    $idTest = ""){

            //actualizar estado del examen

        if(!$this -> forms -> empty_data_two($status) ||  
           !$this -> forms -> empty_data($idTest)){

              $msg = $this -> status_query("no-data", "Faltan datos para actualizar el estado");
                  
        }else{

            $status = $this -> data_cleaner($status);
            $idTest = $this -> data_cleaner($idTest);

            $newStatus = 0;

            switch($status){
            
                case "0":
                
                  $status = "1";
                
                break;
                case "1":
                  
                  $status = "0";
                
                break;
                default:             
                 
                  $status = "error";
                
                break;
            
            }

            if($status == "error"){

                $setStatus =  "error";
                $setNotice = "Status no reconocido status".$status;

            }else{

                $setOne = $this -> crud("update examenes set exam_status='$status', exam_fechaActualizar='".$this -> date."' where exam_id='$idTest'", 
                                    "Error al editar examen",
                                    "Estado del examen editado correctamente",
                                    "Error al editar examen");
             
                $setStatus = $setOne["status"];
                $setNotice = $setOne["notice"]; 

                if($setOne["status"] == "done"){

                    $newStatus = $status;

                }else{

                    $newStatus = $setOne["notice"];

                }      

            }
                    

            $msg = $this -> status_query($setStatus, 
                                         $setNotice,
                                         $newStatus);
        
        }//verificar campos vacios

        return $msg;

    }

    public function set_question($question = "",
                                 $idQuestion = "",
                                 $idTest = ""){

            //actualizar pregunta

        if(!$this -> forms -> empty_data($question) ||  
           !$this -> forms -> empty_data($idTest)){

                    $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
                }else{

                    $question = $this -> data_cleaner(rtrim($question));
                    $idTest = $this -> data_cleaner($idTest);
                    $idQuestion = $this -> data_cleaner($idQuestion);

                    $setOne = $this -> crud("update preguntas set preg_pregunta='$question', preg_fechaActualizacion='".$this -> date."' where preg_id='$idQuestion' and preg_examen='$idTest'", 
                                            "Error al editar pregunta",
                                            "Pregunta editada correctamente",
                                            "Error al editar pregunta");
                    
                    $newQuestion = "";

                    if($setOne["status"] == "done"){

                        $newQuestion = $question;

                    }else{

                        $newQuestion = $setOne["notice"];

                    }      

                    $msg = $this -> status_query($setOne["status"], 
                                                 $setOne["notice"],
                                                 $newQuestion);
                }//verificar campos vacios

      return $msg;

    }

    public function set_answer($answer = "",
                                    $idQuestion = "",
                                    $idTest = "",
                                    $idAnswer = ""){

        //actualizar respuesta

        if(!$this -> forms -> empty_data($answer) ||  
           !$this -> forms -> empty_data($idQuestion) ||  
           !$this -> forms -> empty_data($idTest) ||  
           !$this -> forms -> empty_data($idAnswer)){

            $msg = $this -> status_query("info", $this -> info_msg("Hay campos vacios"));
        
        }else{

            $answer = $this -> data_cleaner(rtrim($answer));
            $idTest = $this -> data_cleaner($idTest);
            $idQuestion = $this -> data_cleaner($idQuestion);
            $idAnswer = $this -> data_cleaner($idAnswer);

            $setOne = $this -> crud("update respuestas set resp_texto='$answer', resp_fechaActualizacion='".$this -> date."' where resp_id='$idAnswer' and resp_pregunta='$idQuestion' and resp_examen='$idTest'", 
                                    "Error al editar respuesta",
                                    "Respuesta editada correctamente",
                                    "Error al editar respuesta");
            
            $newAnswer = "";

            if($setOne["status"] == "done"){

                $newAnswer = $answer;

            }else{

                $newAnswer = $setOne["notice"];

            }      

            $msg = $this -> status_query($setOne["status"], 
                                         $setOne["notice"],
                                         $newAnswer);
      }

      return $msg;

    }

    
    /*****agregar*****/

    public function add_one($data = ""){

        //registrar examenes

	      if($this -> forms -> empty_data($data)){

            extract($data);

    				if(!$this -> forms -> empty_data($testName) ){

                $msg = $this -> status_query("info", $this -> info_msg("Hay campos vacios"));
            
            }else{

                $nombre = $this -> data_cleaner($testName);
                $status = '1';
                $date = $this -> date;

                $search = $this -> search("select exam_id, exam_nombre from examenes where exam_nombre='$nombre'", 
                                          "Error al buscar examen registrado");
                
                if($search["status"] == "done"){
                   
                  $msg = $this -> status_query("no-data", $this -> info_msg("El Examen  ".$nombre." ya ha sido registrado"));

                }else if($search["status"] == "no-data"){

                  //registrar examen

                	$addOne = $this -> crud("insert into examenes (exam_nombre, exam_status, exam_fechaRegistro) values ('$nombre','$status','$date' )", "Error al registrar examen<br>");
                      
                  $msg = $this -> status_query("done", $this -> success_msg("Examen registrado correctamente en la base de datos"));


                }else{

                    //error

                	$msg = $this -> status_query("error", $this -> danger_msg("Error al registrar examen"));
                
                }
                        
            }// fin de if de verificacion de campos vacios


  			}else{

  				$msg = $this -> status_query("warning", $this -> warning_msg("Sin datos"));;

  			}//verificacion de parametros vacios

  			 return $msg;

		}

    public function add_instructions($idTest = "", 
                                     $instructions = ""){

        if(!$this -> forms -> empty_data($_POST["instructions"]) ||
           !$this -> forms -> empty_data($_POST["idTest"])){

            return status_query("no-data", "Hay campos vacios", "vacio");                  

        }else{

            $instructions = $this -> data_cleaner(rtrim($_POST["instructions"]));
            $idTest = $this -> data_cleaner($_POST["idTest"]);

            $addInst = $this -> crud("update examenes set exam_instrucciones='$instructions' where exam_id='$idTest'",
                                     "Error al registrar instrucciones",
                                     "Instrucciones registradas exitosamente",
                                     "Error al registrar instrucciones");

            return  $this -> status_query($addInst["status"], $addInst["notice"], $addInst["data"]); 
        
        }

    }

    public function add_question($idTest = "", 
                                 $question = ""){

        if(!$this -> forms -> empty_data($_POST["question"]) ||
           !$this -> forms -> empty_data($_POST["idTest"])){

            return status_query("no-data", $this -> info_msg("Hay campos vacios"), "vacio");                  

        }else{

            $question = $this -> data_cleaner(rtrim($_POST["question"]));
            $idTest = $this -> data_cleaner($_POST["idTest"]);
            $dataQuestion = "";

            $addQuestion = $this -> crud("insert into preguntas (preg_pregunta, preg_examen) values ('$question', '$idTest')",
                                     "Error al registrar pregunta",
                                     "Pregunta registrada exitosamente",
                                     "Error al registrar pregunta");

            $getQuestions = $this -> get_questions($idTest);
            
            if($getQuestions["status"] == "done"){

                $dataQuestion = $this -> write_questions($getQuestions["data"], 
                                         $idTest);

                
            }else{

                $dataQuestion = $getQuestions["notice"];
            
            }

            return  $this -> status_query($addQuestion["status"], $addQuestion["notice"], $dataQuestion); 
        
        }

    }

    public function add_answer($answer = "", 
                               $idQuestion = "",
                               $idTest = ""){

        if(!$this -> forms -> empty_data($_POST["answer"]) ||
           !$this -> forms -> empty_data($_POST["idQuestion"]) ||
           !$this -> forms -> empty_data($_POST["idTest"])){

            return status_query("no-data", $this -> info_msg("Hay campos vacios"), "vacio");                  

        }else{

            $answer = $this -> data_cleaner(rtrim($_POST["answer"]));
            $idQuestion = $this -> data_cleaner($_POST["idQuestion"]);
            $idTest = $this -> data_cleaner($_POST["idTest"]);
            $dataAnswer = "";
            $correct = 0;
            $fechaRegistro = $this -> dateTime;

            $addAnswer = $this -> crud("insert into respuestas (resp_texto, resp_pregunta, resp_examen, resp_correcta, resp_fechaRegistro) values ('$answer', '$idQuestion', '$idTest', $correct, '$fechaRegistro')",
                                     "Error al registrar respuesta",
                                     "Respuesta registrada exitosamente",
                                     "Error al registrar respuesta");


            $dataAnswer = $this ->  load_answers($idQuestion,
                                                 $idTest);

            return  $this -> status_query($addAnswer["status"], $addAnswer["notice"], $dataAnswer); 
        
        }

    }

    public function add_correct_answer($idQuestion = "",
                                     $idTest = "", 
                                     $idAnswer = "",
                                     $correct = ""){

        if(!$this -> forms -> empty_data($_POST["idAnswer"]) ||
           !$this -> forms -> empty_data($_POST["idQuestion"]) ||
           !$this -> forms -> empty_data($_POST["idTest"]) ||
           !$this -> forms -> empty_data_two($_POST["correct"])){

            return status_query("no-data", $this -> info_msg("Hay campos vacios"), "vacio");                  

        }else{

            $newCorrect = "";
            
            if($correct == "1"){

              $update = $this -> crud("update respuestas set resp_correcta='0' where resp_examen='$idTest' and resp_pregunta='$idQuestion' and resp_id='$idAnswer'",
                                      "Error al desmarcar respuesta como correcta",
                                      "Respuesta desmarcada como correcta",
                                      "Error al desmarcar respuesta como correcta");
              if($update["status"] == "done"){

                $newCorrect = "0";
              
              }

            }else if($correct == "0"){

              $update = $this -> crud("update respuestas set resp_correcta='1' where resp_examen='$idTest' and resp_pregunta='$idQuestion' and resp_id='$idAnswer'",
                                      "Error al marcar respuesta como correcta",
                                      "Respuesta marcada como correcta",
                                      "Error al marcar respuesta como correcta");
                if($update["status"] == "done"){

                  $newCorrect = "1";
              
                }

            }else{

              $update = "error";

            }

            if($update == "error"){

              return  $this -> status_query("error", "No se reconoce valor de correcta o incorrecta", "error"); 
        
            }else{

              return  $this -> status_query($update["status"], $update["notice"], $newCorrect); 
          
            }
            
        }

    }

    public function its_done_test($idTest = "", $idStudent = ""){

        if(!$this -> forms -> empty_data($idTest) ||
           !$this -> forms -> empty_data($idStudent)){

              return $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"), "vacio");                  

          }else{

              $test = $this -> data_cleaner(rtrim($idTest));
              $student = $this -> data_cleaner($idStudent);

              $search = $this -> search("select * from examenes_realizados where er_examen='$idTest' and er_alumno='$idStudent'",
                                       "Error al buscar examen realizado",
                                       $this -> success_msg("Busqueda de examen exitosa exitosamente"),
                                       $this -> info_msg("No se encontraron resultados"),
                                       $this -> danger_msg("Error al buscar examen realizado"));


              return  $this -> status_query($search["status"], $search["notice"], $search["data"]);
          
          }

    }

    public function save_test_results($test = "", 
                                      $student = "", 
                                      $correct = "", 
                                      $incorrect = "",
                                      $promedio = ""){

            if(!$this -> forms -> empty_data($test) ||
               !$this -> forms -> empty_data($student) ||
               !$this -> forms -> empty_data_two($correct) || 
               !$this -> forms -> empty_data_two($incorrect) || 
               !$this -> forms -> empty_data_two($promedio)){

                return $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"), "vacio");                  

            }else{

                $test = $this -> data_cleaner(rtrim($test));
                $student = $this -> data_cleaner($student);

                $search = $this -> search("select er_id from examenes_realizados where er_examen='$test' and er_alumno='$student'",
                                          "Error al verificar si el examen ya fue realizado",
                                          $this -> info_msg("El examen ya ha sido registrado"),
                                          $this -> info_msg("Registrando el examen"),
                                          $this -> danger_msg("Error al verificar si el examen ya fue realizado"));
                
                if($search["status"] == "no-data"){

                  $correct = $this -> data_cleaner($correct);
                  $incorrect = $this -> data_cleaner(rtrim($incorrect));
                  $promedio = $this -> data_cleaner(rtrim($promedio));
                  $date =  $this -> dateTime;

                  $addTest = $this -> crud("insert into examenes_realizados (er_examen, er_alumno, er_correctas, er_incorrectas, er_promedio) values ('$test', '$student', '$correct','$incorrect', $promedio)",
                                         "Error al registrar examen realizado",
                                         $this -> success_msg("Su examen ha quedado registrado exitosamente"),
                                         $this -> danger_msg("Error al registrar examen realizado"));
                }else{

                  $addTest["status"] = $search["status"];
                  $addTest["notice"] = $search["notice"];
                  $addTest["data"] = $search["data"];
                
                }

                return  $this -> status_query($addTest["status"], $addTest["notice"], $addTest["data"]);
            
            }

    }
		
    
    /*****borrar*****/

    public function del_test($idTest = ""){

        //borrar pregunta

        if(!$this -> forms -> empty_data($idTest)){

            $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
        }else{

            $idTest = $this -> data_cleaner($idTest);
            $testTable = "";
      
            $delTest = $this -> crud("delete from examenes where exam_id='$idTest'", 
                                    "Error al borrar el examen",
                                    "Examen borrado correctamente",
                                    "Error al borrar el examen");

            $delEr = $this -> crud("delete from examenes_realizados where er_examen='$idTest'", 
                                    "Error al borrar examenes realizados",
                                    "Examenes realizados borrados correctamente",
                                    "Error al borrar el examenes realizados");

            $delQue = $this -> crud("delete from preguntas where preg_examen='$idTest'", 
                                    "Error al borrar preguntas",
                                    "Preguntas borradas correctamente",
                                    "Error al borrar preguntas");

            $delAns = $this -> crud("delete from respuestas where resp_examen='$idTest'", 
                                    "Error al borrar respuestas",
                                    "Respuestas borradas correctamente",
                                    "Error al borrar respuestas");

            $delConfig = $this -> crud("delete from configuracion_de_examen where configEx_examen='$idTest'", 
                                    "Error al borrar configuracion de examen",
                                    "Configuracion borrados correctamente",
                                    "Error al borrar configuracion");

            //preguntas, respuestas, respuestas correctas configuracion de examen


            if($delTest["status"] == "done" && 
               $delEr["status"] == "done" &&
               $delQue["status"] == "done" &&
               $delAns["status"] == "done" &&
               $delConfig["status"] == "done"){

                $testTable = $this -> show_test();                

            }else{
              
                $testTable = $delTest["notice"].$delEr["notice"].$delQue["notice"].$delAns["notice"].$delConfig["notice"];

            }
            
            $msg = $this -> status_query($delTest["status"], 
                                         $delTest["notice"],
                                         $testTable);
        }//verificar campos vacios

      return $msg;

    }

    public function del_question($idQuestion = "",
                                 $idTest = ""){

        //borrar pregunta

        if(!$this -> forms -> empty_data($idQuestion) ||  
           !$this -> forms -> empty_data($idTest)){

                    $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
        }else{

            $idTest = $this -> data_cleaner($idTest);
            $idQuestion = $this -> data_cleaner($idQuestion);
            $dataQuestion = "";
            $status = "error";
            $notice = "error";

            $delAns = $this -> crud("delete from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest'", 
                                    "Error al borrar la respuesta",
                                    "Respuesta borrada correctamente",
                                    "Error al borrar la respuesta");

            if($delAns["status"] == "done"){

                $delOne = $this -> crud("delete from preguntas where preg_id='$idQuestion' and preg_examen='$idTest'", 
                                    "Error al borrar pregunta",
                                    "Pregunta borrada correctamente",
                                    "Error al borrar pregunta");

                $status = $delOne["status"];
                $notice = $delOne["notice"];

                $getQuestions = $this -> get_questions($idTest);
                
                if($getQuestions["status"] == "done"){

                    $dataQuestion = $this -> write_questions($getQuestions["data"], 
                                                             $idTest);

                }else{

                    $dataQuestion = $notice;
                
                }                

            }
            
            $msg = $this -> status_query($status, 
                                         $notice,
                                         $dataQuestion);
        }//verificar campos vacios

      return $msg;

    }

    public function del_answer($idQuestion = "",
                                 $idAnswer = "",
                                 $idTest = ""){

        //borrar pregunta

        if(!$this -> forms -> empty_data($idQuestion) ||
          !$this -> forms -> empty_data($idAnswer) ||  
           !$this -> forms -> empty_data($idTest)){

                    $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
        }else{

            $idTest = $this -> data_cleaner($idTest);
            $idQuestion = $this -> data_cleaner($idQuestion);
            $idAnswer = $this -> data_cleaner($idAnswer);
            $dataAnswer = "";

            $delAns = $this -> crud("delete from respuestas where resp_pregunta='$idQuestion' and resp_examen='$idTest' and resp_id='$idAnswer'", 
                                    "Error al borrar la respuesta",
                                    "Respuesta borrada correctamente",
                                    "Error al borrar la respuesta");

            if($delAns["status"] == "done"){

                $getAnswers = $this -> load_answers($idQuestion, 
                                                    $idTest);
                
                $dataAnswers = $getAnswers;

                
            }

            $msg = $this -> status_query($delAns["status"], 
                                         $delAns["notice"],
                                         $dataAnswers);
        }//verificar campos vacios

      return $msg;

    }

    public function del_student_er($idTest = "", $idStudent = ""){

        //borrar pregunta

        if(!$this -> forms -> empty_data($idTest) ||
          !$this -> forms -> empty_data($idStudent)){

            $msg = $this -> status_query("no-data", $this -> info_msg("Hay campos vacios"));
                
        }else{

            $idTest = $this -> data_cleaner($idTest);
            $idStudent = $this -> data_cleaner($idStudent);
            
            $testTable = "";

            $delEr = $this -> crud("delete from examenes_realizados where er_examen='$idTest' and er_alumno='$idStudent'", 
                                    "Error al borrar examen realizado",
                                    "Examen borrado correctamente",
                                    "Error al borrar el examen realizado");

            if($delEr["status"] == "done"){

                $testTable = $delEr["notice"];                

            }else{
              
                $testTable = $delEr["notice"];

            }
            
            $msg = $this -> status_query($delEr["status"], 
                                         $delEr["notice"],
                                         $testTable);
        
        }//verificar campos vacios

      return $msg;

    }

    public function get_doneTest_num($idStudent = ""){
        //numero de examenes realizados por el alumno
        $search = $this -> search("select * from examenes_realizados inner join examenes on exam_id=er_examen where er_alumno = '$idStudent'",
                                 "Error al buscar examenes", 
                                 $this -> success_msg("Mostrando examenes"),
                                 $this -> info_msg("No se encontraron examenes realizados"),
                                 $this -> danger_msg("Error al buscar examenes"));
        
        $number = 0;

        if($search["status"] == "done"){

          $number = mysqli_num_rows($search["data"]);

        }
        
        return $number;

    }

    public function get_done_test($idStudent = "", $limit = "", $pageIni = ""){

        //obtener examenes realizados del alumno
        $testList = "";

        if($limit != "" && $pageIni != ""){$pageIni = "limit ".$pageIni.", ";}
        if($limit != "" && $pageIni == ""){$pageIni = "limit ".$pageIni;}
        
      
        $search = $this -> search("select * from examenes_realizados inner join examenes on exam_id=er_examen inner join configuracion_de_examen on configEx_examen=er_examen  where er_alumno = '$idStudent' $pageIni $limit",
                                 "Error al buscar examenes", 
                                 $this -> success_msg("Mostrando examenes"),
                                 $this -> info_msg("No se encontraron examenes realizados"),
                                 $this -> danger_msg("Error al buscar examenes"));
                
        $tableStar = "<div class='col-12 col-sm-4 col-md-3 content-item'>
                          <table class='table exam-table' id='exam-table'>";
        $table = "";
        $tableEnd = "</table></div>";
        $status = "";

        if($search["status"] == "done"){
         
          while ($row = mysqli_fetch_assoc($search["data"])) {
            
              if($row["er_promedio"] >=  $row["configEx_promMin"]){

                $status = "<div class='bg-colorGreen status'>Aprobado</div>";

              }else{

                  $status = "<div class='bg-colorRed status'>No aprobado</div>";

              }
         
                      $table = $table.$tableStar."<tr>
                                                    <td class='head-card'>
                                                        <div class='td-testName'>
                                                          $row[exam_nombre]
                                                        </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class='test-listItem'>
                                                          Correctas: $row[er_correctas]
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class='test-listItem'>
                                                          Incorrectas: $row[er_incorrectas]
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class='test-listItem'>
                                                          Promedio: $row[er_promedio]
                                                    </td>
                                                  </tr><tr>
                                                    <td class='test-listItem'>
                                                          Status: $status
                                                    </td>
                                                  </tr>".$tableEnd;

          }

        }

        return $this -> status_query($search["status"], $search["notice"], $table);

    }

    public function get_exam_time($hourExp = "", 
                                  $dateExp = "", 
                                  $hourAp = "",
                                  $dateAp = ""){

      //calcular la duracion del examen

        $dateExp = strtotime($dateExp." ".$hourExp);
        
        $dateAp = strtotime($dateAp." ".$hourAp);

        $toMinuts = ($dateExp - $dateAp)/60;

        $hours = $toMinuts/60;

        $minuts = $hours - floor($hours);

        $minuts = $minuts * 60;

        //dar formato a las horas
        $n = explode(".", $hours);

        $hours = floor($hours);

       
        if( $hours < 1 ) {

            $hours = "00";

        }else if ( $hours < 10 ){

            $hours = "0".$hours;

        }else{ 

        }

       //dar formato alos minutos
        /*como los minutos se muestran en decimal dividirlos en enteros y decimales 
        para dar un formato correcto*/
        $numbers = explode(".", $minuts); 

        $number = $minuts - $numbers[0];

        if( $number > 0 && $number < 1 ){

            //si ya se mostro en decimal sumarle a la parte entera uno
            $minuts = $numbers[0] + 1;
        
        }else{

            $minuts = $numbers[0];
        
        }

        if( $minuts < 1 ) {

            $minuts = "00";

        }else if ( $minuts < 10 ){

            $minuts = "0".$minuts;

        }else{ 

        }

        return $hours.":".$minuts;

    }

    public function verify_do_date($date = "", $hour = ""){

        //fecha de expiracion
        $dateCorrect = strtotime($date);
            
        //fecha actual
        $date = strtotime(date("d-m-Y", time()));
       
        if($date == $dateCorrect){

          return true;

        }else{

          return false;

        }

    }

    public function verify_do_dateTime($date = "", $hour = ""){

        //fecha de expiracion
        $dateCorrect = strtotime($date);
        $hourCorrect = strtotime($hour);
            
        //fecha actual
        $date = strtotime(date("d-m-Y", time()));
        $hour = strtotime(date("H:i:s", time()));
       
        if($date == $dateCorrect && $hour >= $hourCorrect){

          return true;

        }else{

          return false;

        }

    }

    public function get_student_testList($idStudent = ""){

        //obtener datos de todos los examenes
        $testList = "";
      
        $search = $this -> search("select * from examenes inner join configuracion_de_examen on configEx_examen=exam_id");

        $ulStar = "<table class='table test-list'> 
                     <tr>
                        <th>Examen</th>
                        <th>Fecha y hora de aplicacion</th>
                        <th>Fecha y hora Limite</th>
                        <th>Duracion</th>
                     </tr>";
        $listBody = "";
        $ulEnd = "</table>";
        $c = 0;

        if($search["status"] == "done"){
            
            $time = "00:00";

            while ($row = mysqli_fetch_assoc($search["data"])) {
                
                //verificar si aun se puede hacer el examen
                if($this -> verify_expired_time($row["configEx_fechaDeExpiracion"],
                                                 $row["configEx_horaDeExpiracion"]) && 
                  $this -> verify_do_date($row["configEx_fechaDeAplicacion"]) && 
                  $row["exam_status"] == "1"){

                      //verificar i el alumno no ha realizado el examen
                      $getTest = $this -> search("select er_examen from examenes_realizados where er_alumno = '$idStudent' and er_examen='$row[exam_id]'",
                                     "Error al buscar examenes", 
                                     "Mostrando examenes",
                                     "No se encontraron examenes realizados",
                                     "Error al buscar examenes");
                      
                      if($getTest["status"] == "no-data"){
                          
                          //obtener el tiempo de duracion del examen 
                           $time = $this -> get_exam_time($row["configEx_horaDeExpiracion"],
                                                          $row["configEx_fechaDeExpiracion"],
                                                          $row["configEx_horaDeAplicacion"],
                                                          $row["configEx_fechaDeAplicacion"]);

                          //elaborar la lista de examenes que puede hacer el alumno
                          $listBody = $listBody."<tr><td class='test-listItem'>
                                                    <a href='hacer_examen.php?examen=$row[exam_id]'>
                                                        $row[exam_nombre]
                                                    </a>
                                                 </td>
                                                 <td class='test-listItem'>
                                                        $row[configEx_horaDeAplicacion] / $row[configEx_fechaDeAplicacion]
                                                 </td>
                                                 <td class='test-listItem'>
                                                        $row[configEx_horaDeExpiracion] / $row[configEx_fechaDeExpiracion]
                                                 </td>
                                                 <td class='test-listItem'>
                                                    $time
                                                 </td>
                                                 </tr>";

                          $c++;

                      }                   
              
                }

            }

        }

        if($c > 0){

          $testList = $ulStar.$listBody.$ulEnd;

        }else{

          $testList = $this -> info_msg("No hay examenes que realizar");
        
        }
        
        return $this -> status_query($search["status"], $search["notice"], $testList);

    }

	}

?>
