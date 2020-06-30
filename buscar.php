<!doctype html>


<?php
    require "BD.php";
    
?>




<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="static/css/pancho.css">
    <link rel="stylesheet" type="text/css" href="static/css/estilos.css">
    <title>The Wall</title>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="static/js/validar.js"></script>
</head>


<body>

    <header class="header">
        <div class="container logo-nav-container">
            <img class="logoW" src="static/img/logo2.jpg" />
            <a href="#" class="logo"> The Wall</a>
            <nav class="navegacion">
                <ul>
                <li>
          <form  action="buscar.php" method="POST" >
            
              <input type="text" name="busqueda" id="buscador" placeholder="Buscar usuario" class="form-control">
              </li>
              <button type="submit" class="btn btn-info mb-1" id="botonBuscador"><i class="fa fa-search"></i></button>
          </form>
                    <li id="resultado"></li>
                    <li><a href="index.php">Inicio </a></li>
                    <li><a href="miPerfil.php">Perfil </a></li>
                    <li><a href="editarPerfil.php">Configuracion </a></li>
                    <li><a href="login.php"> Cerrar Sesion </a></li>
                </ul>
            </nav>
        </div>

    </header>

    <?php
    require "BD.php";
    session_start();
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idLogueado = $_SESSION['id'];

    ?>
    <div class="contenedor">        
        <ul class="seguidores">
            <h3 class="nombre">Seguidores:</h3>
            
            <?php 
            $busqueda=$_POST['busqueda'];
            $sql= "SELECT u.id, u.nombre, u.apellido, u.nombreusuario, u.foto_contenido FROM usuarios u INNER JOIN siguiendo s ON (s.usuarioseguido_id=u.id) WHERE ($idLogueado=s.usuarios_id) AND ((u.nombre LIKE '$busqueda%') OR (u.nombreusuario LIKE '$busqueda%') OR (u.apellido LIKE '$busqueda%'))";
            $result = mysqli_query($conn, $sql);   
            while ($datos = mysqli_fetch_array($result)) {
            if (isset($datos[0])) {
                $nombre=$datos['nombre'];
                $apellido=$datos['apellido'];
                $nombreUsuario=$datos['nombreusuario'];
                $idBuscado=$datos['id'];
                $bytesImagen=$datos['foto_contenido'];
                ?>
                <li>
                <form  action="validarSeguir.php" method="POST" >
                    <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt=""> 
                    <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idBuscado ?>"><?php echo "$nombre "; echo $apellido; ?></a>
                    <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idBuscado ?>"><?php echo "($nombreUsuario)" ?></a>
                    <button type= "submit" class="dejarDeSeguir"  >Dejar de Seguir</button>               
                    <input type="hidden"   name="usuarioSeguido" value="<?php echo $nombreUsuario?>">
                    <input type="hidden"    name="US_id" value="<?php echo $idBuscado?>"> 
                    </li>
                    <?php
                            }
                                   
                        }?>
                </form>

                
        
                <?php
                
                $sql = "SELECT u.id, u.nombre, u.apellido, u.nombreusuario, u.foto_contenido FROM usuarios u  WHERE ((u.nombre LIKE '$busqueda%') OR (u.nombreusuario LIKE '$busqueda%') OR (u.apellido LIKE '$busqueda%')) AND u.id NOT IN (SELECT s.usuarioseguido_id FROM siguiendo AS s WHERE 195=s.usuarios_id ) ";
                $result = mysqli_query($conn, $sql);   
                while ($datos = mysqli_fetch_array($result)) {
                if (isset($datos[0])) {
                    $nombre=$datos['nombre'];
                    $apellido=$datos['apellido'];
                    $nombreUsuario=$datos['nombreusuario'];
                    $idBuscado=$datos['id'];
                    $bytesImagen=$datos['foto_contenido'];
                    ?>
                    <li>
                    <form  action="validarSeguir.php" method="POST" >
                        <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt=""> 
                        <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idBuscado ?>"><?php echo "$nombre "; echo $apellido; ?></a>
                        <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idBuscado ?>"><?php echo "($nombreUsuario)" ?></a>
                        <button type= "submit" class="seguir"  >Seguir</button>               
                        <input type="hidden"   name="usuarioSeguido" value="<?php echo $nombreUsuario?>">
                        <input type="hidden"    name="US_id" value="<?php echo $idBuscado?>"> 
                    </li>
                    <?php                    
                        }
                    }?>
                    </form>
                    </ul>     
    </div>
    
    <!-- Footer -->
    <footer class="page-footer font-small blue">


        <div class="footer">
            <a> Francisco Pavon - Santiago Goggi</a>
        </div>

    </footer>
    <!-- Footer -->
</body>

</html>