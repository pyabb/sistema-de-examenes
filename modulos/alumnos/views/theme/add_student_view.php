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

                    require_once('modulos/alumnos/views/theme/inc/menu_gen.php');

                ?>

                <div class="page-wrap">
                
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="index.php">Login</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registrar alumno</li>
                          </ol>
                        </nav>
                    </div>

                    <h1 class="title-page">
                            
                        <span class="fas fa-user"></span> &nbsp Registro de alumnos

                    </h1>

                    <section class="content">
                      
                        <?php

                            echo $addStudentForm;

                        ?>

                    </section>
                
                </div>

            </div><!--main-container-->

    </body>

</html>