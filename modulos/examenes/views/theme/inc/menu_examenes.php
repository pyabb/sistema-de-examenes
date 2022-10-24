<header>
    <nav class="navbar navbar-inverse" role="navigation">
    <!-- El logotipo y el icono que despliega el menú se agrupan       para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <button type="button"class="navbar-toggle" data-toggle="collapse"            data-target=".navbar-ex1-collapse">
                <span class="sr-only">Desplegar navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Sistema de examenes</a>
        </div>
        <!-- Agrupar los enlaces de navegación, los formularios y cualquier       otro elemento que se pueda ocultar al minimizar la barra -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text"class="form-control" placeholder="Buscar">
                </div>
                <button type="submit"class="btn btn-default">Enviar</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">         
                        Registrar<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="registrar_alumno.php">Alumnos</a>
                        </li>
                        <li>
                            <a href="examenes.php">Examenes</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">         
                        Administrar<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="alumnos.php">Alumnos</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">         
                        <?php echo $userName; ?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="modulos/administrador/views/theme/admin_perfil.php">Perfil</a>
                        </li>
                        <li>
                            <a href="logout.php">Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

</header>