<!doctype html>
<?php
  include "claseVerificar.php";
  session_start();
  error_reporting(0);
  $s=$_SESSION['usuario'];
  if (!$_GET){
    header('Location:miPerfil.php?pagina=1');
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

<?php if (Verificar::validar_autorizacion($s)) { ?>

<header class="header">
    <div class="container logo-nav-container">
      <img class="logoW" src="static/img/logo2.jpg" />
      <a href="inicio.php" class="logo"> The Wall</a>
      </div>
      <nav class="navegacion">
        <ul >
          <li>
          <form  action="#" method="POST" onsubmit="return validarBuscar();" >
            
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
      <?php 
    if ($_POST){
        $busqueda = $_POST['busqueda'];
        header("Location:buscar.php?busqueda=$busqueda");
    }
    
    ?>

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
        

        <form action="nuevoMensaje.php" method="post" class="form-mensaje" enctype="multipart/form-data" onsubmit="return validarMensaje(img);">
          <div>
            <textarea name="nuevoMensaje" id="mensaje" placeholder="Escriba un nuevo mensaje" maxlength="140" minlength="1" style="width: 230px;height: 120px;"></textarea>
          </div>
          <input type="file" name="img" id="foto" class="botonImagen" value="Seleccionar imagen" >
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
              $rs=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idLogueado' ORDER BY fechayhora DESC " );
              $mensajes_por_pagina=10;
              $cantidad=$rs->num_rows;
              $start= ($_GET['pagina']-1)*$mensajes_por_pagina;    
              $paginas=ceil($cantidad/$mensajes_por_pagina);
              $re=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idLogueado' ORDER BY fechayhora DESC limit $start, $mensajes_por_pagina" );    
              while ($row = mysqli_fetch_array($re)  ) {
                
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
                
                <form action="" method="post" class="form-mensaje">
                <!-- <input type="hidden"   name="idMensaje" value="<?php// echo $idMensaje?>"> -->
                <input type="submit" onclick="preguntar(<?php echo $idMensaje?>,<?php echo $idLogueado ?>);" value="Eliminar" class="eliminar">
                </form>
                <script type="text/javascript">
                    function preguntar(idMensaje, idLogueado){
                      if (confirm("¿Esta seguro que desea eliminar el mensaje?")){
                        window.location.href = "eliminarMensaje.php?idMensaje=" + idMensaje + "&id=" + idLogueado;
                      }


                    }
                </script>
                
            <?php } ?>
            <?php
            

            
            ?>
                
            </li>


        </ul>

        <ul class="nav nav-pills justify-content-center">
    <li class="page-item <?php echo $_GET['pagina']<= 1 ? 'disabled' : '' ?>  ">
      <a class="page-link" href="miPerfil.php?pagina=<?php echo $_GET['pagina']-1 ?>" > Anterior</a>
      </li>
      <?php for ($i=0; $i<$paginas ;$i++ ) { ?>
        <li class="page-item ">
          <a class="page-link <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?> " href="miPerfil.php?pagina=<?php echo $i+1 ?>" > <?php echo $i+1 ?></a>
        </li>
      <?php } ?>
      <li class="page-item <?php echo $_GET['pagina']>= $paginas ? 'disabled' : '' ?>  ">
        <a class="page-link" href="miPerfil.php?pagina=<?php echo $_GET['pagina']+1 ?>">Siguiente</a>
      </li>
</ul>

    </div>
    <?php } else { ?>
        <header class="header">
            <div class="container logo-nav-container">
            <img class="logoW" src="static/img/logo2.jpg" />
            <a href="inicio.php" class="logo"> The Wall</a>
            </div>
          <nav class="navegacion2">
            <ul >
                    
              <li><a href="index.php">Iniciar Sesion </a></li>
              <li><a href="registrarse.php"> Registrarse </a></li>
            </ul>
          </nav>
    

      </header>
      
      <div class="alertaAutorizacion">
            <p> Para navegar por la página debe Iniciar sesión o Registrarse </p>
      </div>
  


      
          
        
  <?php } ?>

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