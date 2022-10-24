<!doctype html>
<html lang="es">
    <head>
        
        <title>Perfil del alumno</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/alumnos/views/theme/css/student_profile.css">
        
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
                            <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                          </ol>
                        </nav>
                    </div>


                    <h1 class="title-page">
                            
                        Perfil

                    </h1>

                    <section class="content">
                      
                        <div class="form-wraper">
                            
                            <div class="row">
                                <?php

                                    echo $setForm;

                                ?>
                                
                                <div class="change-formWrap col-xs-12 col-sm-12 col-md-6">
     
                                    <form action="" method="post" name="change-passwordForm" id="change-passwordForm" class="change-passwordForm pull-right">
                                    
                                        <h2 class="title-form">Editar Password</h2>

                                        <div class="change-passMsg" id="change-passMsg"></div>
                                    
                                        <div class="form-body">

                                                
                                                <div class="form-group row">
                                                    <label class="label-pass col-sm-3">Password:</label>
                                                    <div class=" col-sm-9">    
                                                        <input type="password" name="password" id="password" class="data-password form-control" tabindex="4" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="label-pass col-sm-3">Confirmar:</label>
                                                    <div class=" col-sm-9">    
                                                        <input type="password" name="confirmPassword" id="confirm-pass" class="data-password form-control" tabindex="5" value="">
                                                    </div>
                                                </div>
                                            
                                           
                                        </div>

                                        <div class="footer-form">

                                            <div class="form-group row footer-formRow">
                                                <div class="col-sm-12">   
                                                    <input type="submit" name="change-password" value="Cambiar" id="change-password" class="btn action-btn" tabindex="6">
                                                </div>
                                            </div><!--footer-form-->

                                        </div>

                                    </form>
                                    
                                </div>      
                                
                            </div>
                            
                        </div>

                    </section>
                
                </div>

            </div><!--main-container-->
            <?php  

                require_once("views/theme/inc/common_js.php");

            ?>
            <script src="modulos/alumnos/views/theme/js/classes/Student.js"></script>
            <script src="modulos/alumnos/views/theme/js/student_profile.js"></script>


    </body>

</html>