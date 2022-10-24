<!doctype html>
<html lang="es">
    <head>
        
        <title>Alumnos evaluados</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="views/theme/css/datatables.min.css">

        <link rel="stylesheet" type="text/css" href="modulos/administrador/views/theme/css/evaluated_students.css">
        
    </head>
    <body>
        
        <div class="main-container">
        
                <?php                    

                    require_once('modulos/administrador/views/theme/inc/menu_admin.php');

                ?>

                <div class="page-wrap">
                    
                     <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="evaluaciones.php">Evaluaciones</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Alumnos evaluados</li>
                          </ol>
                        </nav>
                    </div>
      
                    <h1 class="title-page">
                            
                        Alumnos evaluados

                    </h1>
                    
                    <div class="container-fluid">
                        <div class="row">
                            <h2 class="test-nameH2 col-sm-7">
                                <?php echo $testName;?>    
                            </h2>
                            <div class="search-formWrap col-sm-5 justify-content-end">
                                <form class="search-form" id="search-form">
                                    <div class="dataTables_filter input-group" id="admin-table_filter">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    <div class="page-msg" id="page-msg"></div>
                
                    <section class="content">
                        <section>
                            <p>Listado de alumnos que realizaron el examen <strong><?php echo $testName;?></strong>.</p>
                        </section>
                        <?php

                            echo $table;

                        ?>

                    </section>
                
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
                                Esta seguro que quiere eliminar el alumno <strong><span id="student-nameDel"></span>.</strong>    
                            </span>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn close-modal" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="del-confirm" value="" class="btn del-confirm">Borrar</button>
                      </div>
                    </div>
                  </div>
                </div>

            </div><!--main-container-->
            <?php  

                require_once("views/theme/inc/common_js.php");

            ?>

            <script src="modulos/administrador/views/theme/js/classes/Admin.js"></script>
            
            <script src="views/theme/js/libs/datatables.min.js"></script>
            
            <script src="modulos/administrador/views/theme/js/admin_students_eval.js"></script>


    </body>

</html>