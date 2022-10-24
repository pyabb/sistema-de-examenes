<!doctype html>
<html lang="es">
    <head>
        
        <title>Administrar alumno</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="views/theme/css/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="modulos/administrador/views/theme/css/admin_student.css">
        
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
                            <li class="breadcrumb-item active" aria-current="page">Administrar alumnos</li>
                          </ol>
                        </nav>
                    </div>      
                
                    <div class="header-page">
                        <div class="container-fluid">
                            <div class="row header-pageRow">
                                <h1 class="title-page  col-sm-12 col-md-7">
                                    
                                    Administrar alumnos

                                </h1>
                                <div class="search-formWrap col-sm-12 col-md-5 justify-content-end">
                                  <form class="search-form float-right" id="search-form">
                                    <div class="dataTables_filter input-group" id="admin-table_filter">
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="content">
                        
                        <div class="page-msg" id="page-msg"></div>  
                        
                        <div class="table-wrap" id="table-wrap">
                            <?php

                                echo $table;

                            ?>
                        </div>

                    </section>
                
                </div>

            </div><!--main-container-->

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
                            Esta seguro que quiere eliminar el alumno <span id="student-nameDel"></span>.
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

            <?php  

                require_once("views/theme/inc/common_js.php");

            ?>
            <script src="modulos/alumnos/views/theme/js/classes/Student.js"></script>
            <script src="views/theme/js/libs/datatables.min.js"></script>
            <script src="modulos/administrador/views/theme/js/admin_students.js"></script>

    </body>

</html>