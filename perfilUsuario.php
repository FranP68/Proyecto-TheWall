<!doctype html>
<html lang="es">


<head>
    <title>The Wall</title>
    <link rel="stylesheet" href="estilos.css">

    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="static/css/pancho.css">
    <link rel="stylesheet" type="text/css" href="static/css/estilos.css">
    <!-- <script src="static/js/validar.js"></script> -->

</head>

<body>

    <?php require "BD.php"; ?>
    <?php $idUsuario = ($_GET["idUsuario"]);     
    ?>
    <?php $sql = " SELECT foto_contenido FROM usuarios WHERE id = $idUsuario ";

    $result = mysqli_query($conn, $sql);

    while ($datos = mysqli_fetch_array($result)) {
        $bytesImagen = $datos["foto_contenido"];
    }

    $sql2 = " SELECT nombre, apellido, nombreusuario FROM usuarios WHERE id = $idUsuario ";

    if ($re = mysqli_query($conn, $sql2)) {

        while ($row = mysqli_fetch_array($re)) {
            if (isset($row[0])) {
                $nombre = $row["nombre"];
                $apellido = $row["apellido"];
                $usuario = $row["nombreusuario"];
            }
        }
    }
        else {  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

    ?>

    
   



    <header class="header">
        <div class="container logo-nav-container">
            <img class="logoW" src="static/img/logo2.jpg" />
            <a href="#" class="logo"> The Wall</a>
            <nav class="navegacion">
                <ul>
                    <li>
                        <input type="text" id="buscador" placeholder="Buscar usuario" class="form-control"></li>
                    <button class="btn btn-info mb-1" id="botonBuscador"><i class="fa fa-search"></i></button>
                    <li id="resultado"></li>
                    <li><a href="index.php">Inicio </a></li>
                    <li><a href="miPerfil.php">Perfil </a></li>
                    <li><a href="editarPerfil.php">Configuracion </a></li>
                    <li><a href="login.php"> Cerrar Sesion </a></li>
                </ul>
            </nav>
        </div>

    </header>



    <div class="contenedor">
        <div class="fotoPerfil">
        <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar" alt="">
        <h3 class="nombre"><?php echo "$nombre "; echo $apellido; ?></h3>
    <h3 class="nombre"><?php echo $usuario ?></h3>
            <button class="dejarDeSeguir">Dejar de seguir</button>
        </div>
        <ul class="seguidores">
            <h3 class="nombre">Seguidores:</h3>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioLioM.php">Lionel Messi</a> <a class="usuarioLink" type="button" href="perfilUsuarioLioM.php"> (L10)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioCRfans.php">Cristiano Ronaldo Fans</a> <a class="usuarioLink" type="button" href="perfilUsuarioCRfans.php"> (CR7fans)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioPipi.php">Leandro Atilio Romagnoli</a> <a class="usuarioLink" type="button" href="perfilUsuarioPipi.php"> (pipi10)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>

        </ul>
    </div>

    <div class="mensajes">
        <ul class="men-box">
          
            <h3 class="nombre">Mis mensajes</h3>

            
            <?php
              $rs=mysqli_query ($conn, "SELECT texto,imagen_contenido FROM mensaje WHERE usuarios_id='$idUsuario' ORDER BY fechayhora DESC LIMIT 0,10" );
            
              while ($row = mysqli_fetch_array($rs)  ) {
                    
                ?>    
                <?php echo "<li>$row[0] </li> " ;
                if(isset($row[1])){
                    $bytesImagen = $row["imagen_contenido"];?>
                    <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> "><?php
                }
                ?>
                
                
                
                <button class="meGusta">Me gusta</button>
                <button class="eliminar">Eliminar</button>
                
            <?php } ?>
            <?php
            

            
            ?>
                
            </li>


        </ul>

    </div>


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