<!doctype html>
<html lang="es">
    <head>

        <meta charset="utf-8">

        <title>Escribir examen</title>
        <?php 

            require_once("views/theme/inc/common_head.php");

            require_once("views/theme/inc/common_js.php");


        ?>

        <link rel="stylesheet" type="text/css" href="modulos/examenes/views/theme/css/write_test.css">

    </head>
    <body>
        
       
        <div class="main-container">           
        	<?php                    

                //menu
                require_once('modulos/administrador/views/theme/inc/menu_admin.php');

            ?>

            <div class="page-wrap">
                
                 <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="admin.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="examenes.php">Registro de examenes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Escribir examen</li>
                      </ol>
                    </nav>
                </div>
                
                <h1 class="title-page">
                            
                    <span>Escribir <?php echo $testName; ?></span>
                    
                </h1>

                <section class="content">
                    
                    <div class="" id="ajax-msg"></div>
                                
                    <div class="write-testBar">
                        
                        <button name="addInstructions" id="addInstructions" class="btn add-instructionsBtn">
                            Escribir instrucciones
                        </button>
                        <button name="addQuestions" id="addQuestionBtn" class="btn add-questionsBtn">
                            Agregar pregunta
                        </button>
                        <input type="hidden" name="idTest" id="idTest" class="idTest" value="<?php echo $idTest; ?>">
                        <!--agregar instrucciones-->
                        <div class="add-instructionsWrap" id="add-instructionsWrap">

                            <!--instrucciones-->
                            <form action="" method="post" name="addInstructionsForm" id="idInstuctionsForm" class="add-instructionsForm">
                            
                                <label>Instrucciones del examen:</label>
                                <textarea name="instructionsTxt" class="data-instructions" id="instructionsTxt"></textarea>
                                <div class="footer-form">
                                    <button type="submit" name="send-instructions" class="btn form-btn send-instructionsBtn" id="sendInstructionsBtn">Guardar</button>
                                </div>
                            </form>

                        </div>

                        <div  class="add-questionWrap" id="add-questionWrap">
                            
                            <!--preguntas-->
                            <form action="" method="post" name="addQuestionForm" id="idQuestionForm" class="add-questionForm">
                            
                                <label>Pregunta:</label>
                                <textarea name="questionTxt" class="data-question" id="questionTxt"></textarea>
                                <div class="footer-form">
                                    <button type="submit" name="send-" class="btn send-questionBtn" id="sendQuestionBtn">Guardar</button>
                                </div>
                            </form>

                        </div>
                            
                    </div>

                    <div class="test-container">
                        
                       <?php 

                            echo "<div class='instructions' id='instructions'>".$instructions."</div>
                                  <div class='questions-wrap' id='questions-wrap'>
                                    <ol class='test-listWrap' id='test-listWrap'>
                                        $questions
                                    </ol>
                                 </div>";

                       ?> 
                        
                        
                    </div>

                </section>

            </div>
            
        </div>
        
        <div class="modal" id="del-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Eliminar</h5>
                <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                    <span id="del-modalTxt">
                        Esta seguro que quiere eliminar    
                    </span>.
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn close-modal" data-dismiss="modal">Cerrar</button>
                <button type="button" id="del-confirm" value="" class="btn del-confirm">Borrar</button>
              </div>
            </div>
          </div>
        </div>
        
        <script src="modulos/examenes/views/theme/js/classes/test.js"></script>
        <script src="modulos/examenes/views/theme/js/write_test.js"></script>

    </body>

</html>