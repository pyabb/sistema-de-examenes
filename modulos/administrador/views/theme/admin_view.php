<!doctype html>
<html lang="es">
    <head>

        <meta charset="utf-8">

        <title>Administrador</title>
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/administrador/views/theme/css/admin.css">

    </head>
    <body>

        <div class="main-container">           
            <?php                    

                    require_once('modulos/administrador/views/theme/inc/menu_admin.php');

            ?>
                
            <div class="page-wrap">
                <h1 class="title-page">
                        
                    <span>Bienvenido Administrador</span>
                    
                </h1>

                <section class="content">

                    <div class="content-wrap">
                        <div class="container-fluid">
                            <div class="row">
                                
                                <div class="col-sm-12 col-md-6 no-padding item-tableWrap">
                                    <div class="item-table border-blueItm margin-bottomItm">
                                        <div class="item-tableIcon blue-backgroundIT">
                                            <span class="fas fa-user-graduate"></span>
                                        </div>
                                        <div class="item-tableTxt">
                                            <strong>Alumnos: <?php echo $studentNumber; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 no-padding item-tableWrap">
                                    <div class="item-table border-greenItm">
                                        <div class="item-tableIcon green-backgroundIT">
                                            <span class="fas fa-file-alt"></span>
                                        </div>
                                        <div class="item-tableTxt">
                                            <strong>Examenes: <?php echo $testNumber; ?></strong>
                                        </div>
                                    </div>
                                </div>
                           
                            </div>

                        </div>
                    </div>

                </section>
            
            </div>
            
        </div>

        <?php
            
            require_once("views/theme/inc/common_js.php");
        
        ?>
    
    </body>

</html>