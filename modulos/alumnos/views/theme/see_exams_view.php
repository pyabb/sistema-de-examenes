<!doctype html>
<html lang="es">
    <head>

        <title>Examenes realizados</title>
        
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/see_exams.css">

    </head>
    <body>
        
        <div class="main-container">           
            <?php                    

                require_once('modulos/alumnos/views/theme/inc/students_menu.php');

            ?>
            <div class="page-wrap">

                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="alumno.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Examenes realizados</li>
                      </ol>
                    </nav>
                </div>

                <h1 class="test-name">
                        
                    Examenes realizados

                </h1>

                <section class="content">
                                                    
                    <div class="msg-page"><?php echo $pageMsg; ?></div>

                    <section class="test-wrap" id="test-wrap">
                        <div class="container-fluid">
                            <div class="row" id="test-wrapRow">
                                <?php
                        
                                    echo $testList;

                                ?>
                            </div>
                        </div>
                        <input type="hidden" name="" value="<?php echo $testNumber; ?>" id="test-number"> 
                        <div class="page-paginator" id="page-paginator">
                            <!--page paginator-->   
                        </div>        
                    </section>
               
                </section>
            
        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");

        ?>
        
        <script  src="views/theme/js/libs/jquery.bootpag.min.js"></script>
        <script  src="views/theme/js/classes/PageItemsPaginator.js"></script>
        <script  src="modulos/alumnos/views/theme/js/see_test.js"></script> 
    
    </body>

</html>