<!doctype html>
<html lang="es">
    <head>

        <title>Hacer examen</title>
        
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/do_test.css">

    </head>
    <body>
        
        <div class="main-container">  

            <?php

                require_once('modulos/alumnos/views/theme/inc/students_menu.php');

            ?>

            <div class="page-wrap">

                <div class="breadcrumb-wrap container-fluid">
                    <div class="row">            
                        <nav aria-label="breadcrumb" class="col-12 col-sm-6">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="alumno.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hacer examen</li>
                          </ol>
                        </nav>
                        <div class="time-wrap col-12 col-sm-6">
                            <div class="time float-right">
                                <?php echo $time; ?>
                            </div>
                            <div class="time-txt float-right">Tiempo restante: </div>
                            <input type="hidden" name="timeVal" id="time-val" class="time-val" value="<?php echo $timeVal; ?>">
                        </div>
                    </div>
                </div>

                <section class="content">
                    
                    <p class="nota"><strong>Nota:</strong> Recuerde ver el medidor de tiempo que esta en la parte superior derecha. Debe enviar sus repuestas antes de que finalize el tiempo del examen de lo contrario no se guardaran.</p>
                    
                    <div class="wrap-content">

                        <div class="msg-page"><?php echo $msg; ?></div>

                        <h1 class="title-page <?php echo $hide; ?>">
                                
                            <?php echo $testName; ?>
                            
                        </h1>
                        <section class="questions-numberWrap">
                            <?php

                                echo "<strong>Total de Preguntas: </strong>".$questionsNumber;

                            ?>
                        </section>
                        <section class="instructions-wrap  <?php echo $hide; ?>">
                            
                            <?php  

                                echo $instructions;

                            ?>  

                        </section>
                        
                        <section class="test-wrap">

                            <form action="calificar_examen.php" method="post" name="test-form" id="test-form" class="test-form">

                                <div id="questions-wrap" class="questions-wrap">
                                    <?php

                                        echo $questionsList;

                                    ?>
                                </div>

                                <input type="hidden" name="idTest" id="idTest" class="" value="<?php echo $idTest; ?>">
                                <input type="hidden" name="questionsNumber" id="questions-number" class="" value="<?php echo $questionsNumber; ?>">
                                <input type="<?php echo $typeBtn; ?>" name="sendTestBtn" id="sendTest" class="btn send-testBtn float-right" value="Enviar">
                                <div class="clearFix"></div>
                            </form>
                   
                        </section>

                        <section>
                            
                            <div class="page-paginator" id="page-paginator">
                                <!--page paginator-->   
                            </div>

                        </section>
                    
                    </div>

                </section>

            </div>
            
        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");

        ?>

        <script  src="views/theme/js/libs/jquery.bootpag.min.js"></script>
        <script  src="views/theme/js/classes/Paginator2.js"></script>
        <script type="text/javascript" src="modulos/alumnos/views/theme/js/do_test.js"></script>

    </body>

</html>