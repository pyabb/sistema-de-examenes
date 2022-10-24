<!doctype html>
<html lang="es">
    <head>
        
        <title>Registrar alumno</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/add_students.css">
        
    </head>
    <body>
        
        <div class="main-container">
        
                <?php                    

                    require_once('modulos/administrador/views/theme/inc/menu_admin.php');

                ?>

                <div class="page-wrap">
                    
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb" class="breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Agregar Alumnos</li>
                          </ol>
                        </nav>
                    </div>
      
                    <h1 class="title-page">
                            
                        <span class="fas fa-user-plus"></span>&nbspRegistro de alumnos

                    </h1>

                    <section class="content">
                      
                        <?php

                            echo $addStudentForm;

                        ?>

                    </section>
                
                </div>

            </div><!--main-container-->
            <?php  

                require_once("views/theme/inc/common_js.php");

            ?>
            <script src="modulos/examenes/views/theme/js/classes/test.js"></script>
            <script src="modulos/examenes/views/theme/js/write_test.js"></script>


    </body>

</html>