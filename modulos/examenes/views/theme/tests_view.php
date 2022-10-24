<!doctype html>
<html lang="es">
    <head>

        <meta charset="utf-8">

        <title>Registro de examenes</title>
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="views/theme/css/datatables.min.css">

        <link rel="stylesheet" type="text/css" href="modulos/examenes/views/theme/css/test.css">

    </head>
    <body>

        <div class="main-container">           
        	<?php                    

                    require_once('modulos/administrador/views/theme/inc/menu_admin.php');

            ?>

            <div class="page-wrap">
            
                <section class="content">

                     <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb" class="col-12 col-sm-6 breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registro de examenes</li>
                          </ol>
                        </nav>
                    </div>

                    <h1 class="title-page">
                                
                        <span>Registro de examenes</span>
                        
                    </h1>

                    <div class="add-testBar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="add-testWrap col-12 col-sm-6">
                                    <form action="examenes.php" method="post" class="add-testForm form-inline" role="search" name="add-testForm">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <label for="test-name" id="test-nameLabel" class="test-nameLabel col-12 col-md-3 col-lg-2  no-padding">
                                                    Nombre:
                                                </label>
                                                <input type="text" name="testName" class="form-control test-nameTxt col-8 col-sm-8 col-md-6 col-lg-8" placeholder="Nombre del examen">
                                                <button name="add-testBtn" class="btn add-testBtn col-4 col-sm-4 col-md-3 col-lg-2">
                                                    Registrar
                                                </button>
                                            </div>
                                                  
                                        </div>
                                    </form>  
                                </div>
                                <div class="search-formWrap col-12 col-sm-6">
                                    <div class="col"">
                                        <form class="search-form float-right" id="search-form">
                                            <div class="dataTables_filter input-group" id="admin-table_filter">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>

                    <div class="table-container">

                        <div class="ajax-msg" id="ajax-msg">
                            <?php

                                echo $msg;
                            
                            ?> 
                        </div>
                        
                        <div class="table-container" id="table-container">
                        

                            <?php

                                echo $dataTable;

                            ?>

                        </div>
                    </div>

                </section>
            
            </div>

        </div>
        <div class="modal" id="del-testModal" tabindex="-1" role="dialog">
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
                    <span class="" id="del-modalTxt">
                        Esta seguro que quiere eliminar el examen <strong><span class="" id="modal-testName"></span>.</strong>
                    </span> 
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn close-modal" data-dismiss="modal">Cerrar</button>
                <button type="button" id="del-testConfirm" value="" class="btn del-testConfirm">Borrar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal" id="config-testModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Configuracion</h5>
                <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                
                    <form class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="do-time" class="col-form-label">Hora de aplicacion:</label>
                                    <input type="time" class="form-control data-config" id="do-time" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="do-date" class="col-form-label">Fecha de aplicacion:</label>
                                    <input type="date" class="form-control data-config" id="do-date" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="expiration-time" class="col-form-label">Hora de expiracion:</label>
                                    <input type="time" class="form-control data-config" id="expiration-time" tabindex="3">
                                </div>
                                <div class="form-group">
                                    <label for="expiration-date" class="col-form-label">Fecha de Expiracion:</label>
                                    <input type="date" class="form-control data-config" id="expiration-date" tabindex="4">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="prom-min" class="col-form-label">Promedio minimo:</label>
                                    <input type="number" class="form-control data-config" id="prom-min" tabindex="5">
                                </div>
                            </div>
                        </div>
                    </form>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn close-modal" data-dismiss="modal" tabindex="7">Cerrar</button>
                <button type="button" id="save-configBtn" value="" class="btn save-configBtn" tabindex="6">Guardar</button>
              </div>
            </div>
          </div>
        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");

        ?>
        <script src="views/theme/js/libs/datatables.min.js"></script>
        <script src="modulos/examenes/views/theme/js/classes/Add_test.js"></script>
        <script src="modulos/examenes/views/theme/js/test.js"></script>
    
    </body>

</html>