<!doctype html>
<html lang="es">
    <head>

        <title>Calificar examen</title>
        
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/qualify_test.css">

    </head>
    <body>
        
        <div class="main-container">           
            
            <?php                    

                require_once('modulos/alumnos/views/theme/inc/students_menu.php');

            ?>
            
            <div class="page-wrap">


                <section class="content">

                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="alumno.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Calificar examen</li>
                          </ol>
                        </nav>
                    </div>

                    <div class="msg-page"><?php echo $msgPage; ?></div>

                    <div class="data-testWrap">

                        Numero de preguntas: <strong><?php echo $questionsNum; ?></strong>&nbsp
                        Respuestas correctas: <strong><?php echo $correctNum; ?></strong>&nbsp
                        Respuestas incorrectas: <strong><?php echo $incorrectNum; ?></strong>&nbsp
                        Promedio: <strong><?php echo $promedio; ?></strong>&nbsp
                        Status: <strong><?php echo $itsAprobed; ?></strong>

                    </div>
                    <h1 class="test-name">
                            
                        <?php echo $testName; ?>
                        
                    </h1>

                    <section class="test-wrap">
                        
                        <?php

                            echo $questionsList;

                        ?>
                            
                    </section>
               
                </section>
            
            </div>

        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");

        ?>
    
    </body>

</html>