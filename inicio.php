<!doctype html>

<!-- sirve para controlar que no se entre a una pagina sin antes haber iniciado sesion -->

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

<!--  --------------------------                                          -->

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
          <form  action="buscar.php" method="POST" onsubmit="return validarBuscar();">
            
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

  <body>
    <?php
    require "BD.php";
    
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idLogueado = $_SESSION['id'];
    ?>

    <div class="cuadroPerfil">
      <div class="fotoPerfil2">


        <?php $sql = " SELECT foto_contenido FROM usuarios WHERE nombreusuario = '$usuario' ";

        $result = mysqli_query($conn, $sql);

        while ($datos = mysqli_fetch_array($result)) {
          $bytesImagen = $datos["foto_contenido"];
        }
        ?>

        <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
        <h3 class="nombre2"><?php echo "$nombre ";
                            echo $apellido; ?> </h3>
        <h3 class="nombre2"><?php echo $usuario ?></h3>
      </div>
      <div class="nuevoMensaje">
        <form action="nuevoMensaje.php" method="post" class="form-mensaje" enctype="multipart/form-data" onsubmit="return validarMensaje();">
          <div>
            <textarea name="nuevoMensaje" id="mensaje" placeholder="Escriba un nuevo mensaje" maxlength="140" minlength="1" style="width: 230px;height: 120px;"></textarea>
          </div>
          <input type="file" name="img" class="botonImagen" value="Seleccionar imagen" onchange="validarImagen(this);">
          <input type="submit" class="botonMensaje" value="Enviar mensaje">

        </form>
      </div>
    </div>




    <div class="ultimosMensajes">
      <ul class="men-box2">
        <h3 class="men-box2-title">Ultimos mensajes</h3>
        

          <?php $sql2 = " SELECT m.texto, m.imagen_contenido, u.nombre, u.apellido, u.nombreusuario, u.foto_contenido, s.usuarioseguido_id, m.id,m.usuarios_id FROM mensaje m LEFT JOIN siguiendo s ON (s.usuarioseguido_id = m.usuarios_id) INNER JOIN usuarios u ON (u.id = m.usuarios_id) WHERE ($idLogueado = s.usuarios_id) ORDER BY m.fechayhora DESC "; ?>
          <?php
          if ($re = mysqli_query($conn, $sql2)) {

            while ($row = mysqli_fetch_array($re)) {
              if (isset($row[0])) {
                $bytesImagen = $row["foto_contenido"]; ?>
                
                <form action="validarDejarDeSeguir.php" method="POST" >
                 
                <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
                <?php
                $nombreU = $row["nombre"];
                $apellidoU = $row["apellido"];
                $usuarioSeguido = $row["nombreusuario"];
                $usuarioSeguido_id=$row[6];
                ?>
                <?php $idMensajeDuenio=$row['usuarios_id'];
                if ($idMensajeDuenio!=$idLogueado){ ?>             
                        
                        <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idMensajeDuenio ?>"><?php echo "$nombreU "; echo $apellidoU; ?></a>
                        <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $idMensajeDuenio ?>"><?php echo "($usuarioSeguido)" ?></a>
                    <?php  } else{ ?>
                        
                        <a class="usuarioLink" type="button" href="miPerfil.php"><?php echo "$nombreU "; echo $apellidoU; ?></a>
                        <a class="usuarioLink" type="button" href="miPerfil.php"><?php echo "($usuarioSeguido)" ?></a>
                    <?php }?>
                
                  <input type="hidden"   name="usuarioSeguido" value="<?php echo $usuarioSeguido?>">
                  <input type="hidden"    name="US_id" value="<?php echo $usuarioSeguido_id?>">
                  <?php 
                  if ($idMensajeDuenio!=$idLogueado){ ?> 
                    <button type= "submit" class="dejarDeSeguir"  >Dejar de Seguir</button>
                  <?php } ?> 
                </form>
                <div class="unMensaje">        
                  <li>
                  

                    <?php


                    ?>
                    <?php echo "$row[0] <br><br>";
                    if (isset($row[1])) {
                      $bytesImagen = $row["imagen_contenido"]; ?>
                      <img src='data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> ' style="width: 300px;height: 190px;"><?php
                    }?>
                    <?php $idMensaje=$row[7];
                    $sqlMG="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id";
                    $rsMG=mysqli_query($conn, $sqlMG);
                    if ($rowMG=mysqli_fetch_array($rsMG)){
                        $cantMG=$rowMG[0];
                    }?>
                    </li> 
                    <?php 
                          $sql3="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id AND $idLogueado=mg.usuarios_id ";
                          if ($rs2=mysqli_query($conn, $sql3)){
                          if ($row2=mysqli_fetch_row($rs2)){
                            if($row2[0]==0){?>
                              <form action="ponerMeGusta.php" method="post" class="form-mensaje">
                              <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                              <input type="submit" value="Me gusta (<?php echo $cantMG ?>)" class="meGusta">
                              </form>
                    <?php }
                            elseif ($row2[0]==1){?>
                              <form action="quitarMeGusta.php" method="post" class="form-mensaje">
                              <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                              <input type="submit" value="Ya no me gusta(<?php echo $cantMG ?>)" class="yaNoMeGusta">
                              </form>
                <?php }  
                } }else {
                  echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);  }?>
                  
                  </div> 
            <?php } else {
                  echo "El mensaje esta en blanco";
                }
              }
          } else {
              echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
          } ?>
                 
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