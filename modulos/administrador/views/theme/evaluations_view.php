<!doctype html>
<html lang="es">
    <head>
        
        <title>Evaluaciones</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="views/theme/css/datatables.min.css">
        
        <link rel="stylesheet" type="text/css" href="modulos/administrador/views/theme/css/evaluations.css">
        
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
                            <li class="breadcrumb-item active" aria-current="page">Evaluaciones</li>
                          </ol>
                        </nav>
                    </div>


                    <div class="container-fluid">
                        <div class="row">
                            <h1 class="title-page col-sm-7">
                                    
                                Evaluaciones

                            </h1>
                            <div class="search-formWrap col-sm-5 justify-content-end">
                              <form class="search-form" id="search-form">
                                <div class="dataTables_filter input-group" id="admin-table_filter">
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                    <section class="content">
                      
                        <?php

                            echo $table;

                        ?>

                    </section>
                
                </div>

            </div><!--main-container-->
            <?php  

                require_once("views/theme/inc/common_js.php");

            ?>

            <script src="views/theme/js/libs/datatables.min.js"></script>
            
            <script src="modulos/administrador/views/theme/js/admin_evaluations.js"></script>

    </body>

</html>