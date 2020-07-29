<!doctype html>
<?php
  session_start();
  error_reporting(0);
  $s=$_SESSION['usuario'];
  
  if(($s == NULL) || ($s == "")){
    echo "Debe loguearse primero <br> ";
    ?>
    <a href='index.php'> Ir a iniciar sesion</a>
    <?php
    die();
  }
  
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
      <a href="inicio.php" class="logo"> The Wall</a>
      </div>
      <nav class="navegacion">
        <ul >
          <li>
          <form  action="buscar.php" method="POST" onsubmit="return validarBuscar();" >
            
              <input type="text" name="busqueda" id="buscador" placeholder="Buscar usuario" class="form-control">
              </li>
              <button type="submit" class="btn btn-info mb-1" id="botonBuscador"><i class="fa fa-search"></i></button>
          </form>
          <li><a href="inicio.php">Inicio </a></li>
          <li><a href="miPerfil.php">Perfil </a></li>
          <li><a href="editarPerfil.php">Editar perfil </a></li>
          <li><a href="editarContraseña.php">Editar contraseña </a></li>
          <li><a href="cerrarSesion.php"> Cerrar Sesion </a></li>
        </ul>
      </nav>
    

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
        <div class="fotoPerfil">
            <?php $sql = " SELECT foto_contenido FROM usuarios WHERE nombreusuario = '$usuario' ";

            $result = mysqli_query($conn, $sql);

            while ($datos = mysqli_fetch_array($result)) {
                $bytesImagen = $datos["foto_contenido"];
            }
            ?>

            <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar" alt="">
            <h3 class="nombre"><?php echo "$nombre " ; echo $apellido;?></h3>
            <h3 class="nombre"><?php echo $usuario?></h3>
        </div>
        

        <form action="nuevoMensaje.php" method="post" class="form-mensaje" enctype="multipart/form-data" onsubmit="return validarMensaje();">
          <div>
            <textarea name="nuevoMensaje" id="mensaje" placeholder="Escriba un nuevo mensaje" maxlength="140" minlength="1" style="width: 230px;height: 120px;"></textarea>
          </div>
          <input type="file" name="img" class="botonImagen" value="Seleccionar imagen" onchange="validarImagen(this);">
          <input type="submit" class="botonMensaje" value="Enviar mensaje">

        </form>


        <ul class="seguidores">
            <h3 class="nombre">Usuarios Seguidos</h3>
            
            <?php $sql2 = " SELECT u.nombre, u.apellido, u.nombreusuario, u.foto_contenido, s.usuarioseguido_id FROM siguiendo s INNER JOIN usuarios u ON (u.id = s.usuarioseguido_id) WHERE ($idLogueado = s.usuarios_id) "; ?>
          <?php
          if ($re = mysqli_query($conn, $sql2)) {

            while ($row = mysqli_fetch_array($re)) {
                if (isset($row[0])) {
                $bytesImagen = $row["foto_contenido"]; ?>
                <form  action="validarDejarDeSeguir.php" method="POST" >
                    <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
                <?php
                $nombreU = $row["nombre"];
                $apellidoU = $row["apellido"];
                $usuarioSeguido = $row["nombreusuario"];
                $usuarioSeguido_id = $row["usuarioseguido_id"];
                ?>

                
                   
                
                
                
                  <input type="hidden"   name="usuarioSeguido" value="<?php echo $usuarioSeguido?>">
                  <input type="hidden"    name="US_id" value="<?php echo $usuarioSeguido_id?>"> 
                  <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $usuarioSeguido_id ?>"><?php echo "$nombreU "; echo $apellidoU; ?></a>
                <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $usuarioSeguido_id ?>"><?php echo "($usuarioSeguido)" ?></a></h3>
                  <button type= "submit" class="dejarDeSeguir"  >Dejar de Seguir</button>
                </form>

                <?php } ?>
                
                
            
                <?php }?>
                </ul>
            
            <?php } ?>
        
    </div>

    <div class="mensajes">
        <ul class="men-box">
          
            <h3 class="nombre">Mis mensajes</h3>

            
            <?php
              $rs=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idLogueado' ORDER BY fechayhora DESC LIMIT 0,10" );
            
              while ($row = mysqli_fetch_array($rs)  ) {
                    
                ?>    
                <?php echo "<li>$row[0] </li> " ;
                if(isset($row[1])){
                    $bytesImagen = $row["imagen_contenido"];?>
                    <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " width="500">
                
                        <?php
                }
                $idMensaje=$row[2];
                $sqlMG="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id";
                $rsMG=mysqli_query($conn, $sqlMG);
                if ($rowMG=mysqli_fetch_array($rsMG)){
                    $cantMG=$rowMG[0];
                }
                
                $sql3="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id AND $idLogueado=mg.usuarios_id ";
                $rs2=mysqli_query($conn, $sql3);
               if ($row5=mysqli_fetch_row($rs2)){
                    if($row5[0]==0){?>
                        <form action="ponerMeGusta.php" method="post" class="form-mensaje">
                        <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                        <input type="submit" value="Me gusta (<?php echo $cantMG ?>)" class="meGusta">
                        </form>
                    <?php }
                    elseif ($row5[0]==1){?>
                        <form action="quitarMeGusta.php" method="post" class="form-mensaje">
                        <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                        <input type="submit" value="Ya no me gusta(<?php echo $cantMG ?>)" class="yaNoMeGusta">
                        </form>
                <?php }  
                } ?>
                
                <form action="eliminarMensaje.php" method="post" class="form-mensaje">
                <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                <input type="submit" value="Eliminar" class="eliminar">
                </form>
                
                
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