<!doctype html>
<html lang="es">
    <head>
        
        <title>Perfil administrador</title>
                
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="modulos/administrador/views/theme/css/admin_profile.css">
        
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
                      
                                <div class="set-formWrap  col-sm-12 col-md-6" id="set-formWrap">

                                    <form action="" method="post" name="change-dataForm" id="change-dataForm" class="change-dataForm">
                                        
                                        <h2 class="title-form">Editar Datos</h2>

                                        <div class="change-dataMsg" id="change-dataMsg"><?php echo $msg; ?></div>
                                    
                                        <div class="form-body">
               
                                            <div class=" form-group row user-typeTxt">
                                                <span class="col-sm-3">Tipo de usuario: </span>
                                                <div class="label-data col-sm-9">
                                                    <span class="userType"><?php echo $typeUser; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3">Usuario:</label>
                                                <div class="label-data col-sm-9">    
                                                    <input type="text" name="usuario" id="user" class="form-control user-data" tabindex="1" value="<?php echo $user; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="label-data col-sm-3">Nombre:</label>
                                                <div class="col-sm-9">    
                                                    <input type="text" name="nombre" id="name" class="form-control user-data" tabindex="2" value="<?php echo $name; ?>">
                                                </div>
                                            </div>                                
                                        
                                        </div>

                                        <div class="footer-form">
                                            
                                            <div class="form-group row footer-formRow ">
                                                <div class="col-sm-12">   
                                                    <input type="submit" name="save-changes" value="Guardar" id="save-changes" class="btn action-btn" tabindex="3">
                                                </div>
                                            </div>
                                        
                                        </div><!--footer-form-->

                                    </form>

                                </div>    
                                <div class="change-formWrap col-sm-12 col-md-6">
         
                                    <form action="" method="post" name="change-passwordForm" id="change-passwordForm" class="change-passwordForm float-right">
                                    
                                        <h2 class="title-form">Editar Password</h2>

                                        <div class="change-passMsg" id="change-passMsg"></div>
                                    
                                        <div class="form-body">
             
                                            <div class="form-group row">
                                                <label class="label-pass col-sm-3">Password:</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" id="password" class="form-control data-password" tabindex="4" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="label-pass col-sm-3">Confirmar Password:</label>
                                                <div class="col-sm-9">    
                                                    <input type="password" name="confirmPassword" id="confirm-pass" class="form-control data-password" tabindex="5" value="">
                                                </div>
                                            </div>                                    
                                       
                                        </div>

                                        <div class="footer-form">
                                            <div class="form-group row footer-formRow">
                                                <div class="col-sm-12">   
                                                    <input type="submit" name="change-password" value="Cambiar" id="change-password" class="btn action-btn" tabindex="6">
                                                </div>
                                            </div>
                                        </div><!--footer-form-->

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
            <script src="modulos/administrador/views/theme/js/classes/Admin.js"></script>
            <script src="modulos/administrador/views/theme/js/admin_profile.js"></script>


    </body>

</html>