<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
    
        <a class="navbar-brand" href="alumno.php" >Sistema de examenes</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse navbar-wrap justify-content-end" id="navbarSupportedContent">
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbarDropdown" role="button" data-toogle="dropdown" aria-haspopup="true" aria-expanded="false">         
                        Evaluaciones<b class="caret"></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="navbarDropdown">
                        <a href="ver_examenes.php"  class="dropdown-item">Ver</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a href=""  class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbarDropdown" role="button" data-toogle="dropdown" aria-haspopup="true" aria-expanded="false">         
                        <?php echo $userName; ?><b class="caret"></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="navbarDropdown">    
                        <a href="perfil_del_alumno.php" class="dropdown-item">Perfil</a>
                        <a href="logout.php" class="dropdown-item">Salir</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>

</header>