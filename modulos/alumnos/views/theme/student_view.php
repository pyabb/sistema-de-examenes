<!doctype html>
<html lang="es">
    <head>

        <title>Alumno</title>
        
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/student.css">

    </head>
    <body>
        
        <div class="main-container">           
        	<?php                    

                require_once('modulos/alumnos/views/theme/inc/students_menu.php');

            ?>

            <div class="page-wrap">

                <h1 class="title-page">
                            
                    Bienvenido/a <?php echo $userName;?>
                    
                </h1>

                <section class="content">
                                        
                    <h2 class="title-pageH2">Evaluaciones pendientes</h2>

                    <p class="page-txt">En este listado aparecen los examenes que puedes hacer.</p>
                        
                    <div class="test-menuWrap">
                        
                        <?php
                           
                            echo $testList;

                        ?>    
                    
                        
                    </div>

                </section>
            
            </div>

        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");

        ?>
    
    </body>

</html>