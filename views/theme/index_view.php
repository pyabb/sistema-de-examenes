<!doctype html>
<html lang="es">
    <head>
    
        <title>Login</title>
    
        <?php 

            require("views/theme/inc/common_head.php");

        ?>

        <link rel="stylesheet" type="text/css" href="views/theme/css/login.css">

    
    </head>
    <body>

        <div class="main-container">

            <div class="content">
                
                <h1 class="title-page">

                    Examenes
                
                </h1>
                
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="login-form" id="login-form" name="login-form">

                        <h1>
                            Login<span class="fas fa-lock float-right"></span>
                        </h1>
                        
                        <div class="msg-form">
                        	<?php  

                        		echo $msg;

                        	?>
                        </div>
                        
                        <div class="form-group row">
                            <label for="usuario" class="col-sm-4"><span class="fas fa-user"></span>&nbspUsuario:</label>
                            <div class="col-sm-8">
                                <input type="text" name="user" class="form-control" id="user" placeholder="Ingrese su usuario">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="pass" class="col-sm-4"><span class="fas fa-key"></span>&nbspPassword:</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" id="pass" placeholder="Ingrese su password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="typeUser" class="col-sm-4"><span class="fas fa-user-tag"></span>&nbspTipo:</label>  
                            <div class="col-sm-8">
                                <select name="typeUser" id="typeUser" class="form-control">
                                	<option value="">Seleccione un tipo de usuario</option>
                                	<option value="admin">Administrador</option>
                                	<option value="alumn">Alumno</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row footer-formWrap">
                            <div class="col-sm-12">
                                <input type="submit" name="login" value="Login" class="btn btn-login" id="login">
                            </div>
                        </div>                    
                </form>

                <div class="add-link" id="addLink">
                    <p>Si no tienes una cuenta registrate <a href="registro_de_alumnos.php" title="click aqui para registrarse">aqui</a>
                    para que puedas tomar tu examen</p>
                </div>

            </div><!--contenedorInicio-->

        </div><!--contenedorPrincipal-->

        <?php

            require_once("views/theme/inc/common_js.php");

        ?>

        <script type="text/javascript" src="views/theme/js/login.js"></script>

    </body>

</html>