<!doctype html>
<html lang="es">
<?php
     include "claseVerificar.php";
  session_start();
  error_reporting(0);
  $s=$_SESSION['usuario'];
  $id_seg=$_GET['idUsuario'];
  if (!$_GET['pagina']){
    header("Location:perfilUsuario.php?idUsuario=$id_seg&pagina=1");
  }
?>

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
    <script src="static/js/validar.js"></script> 

</head>

<body>

    <?php if (Verificar::validar_autorizacion($s)) { ?>


    <?php require "BD.php"; ?>
    <?php $idSeguido = ($_GET["idUsuario"]);
    
    session_start();
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idLogueado = $_SESSION['id'];


    ?>
    <?php $sql = " SELECT foto_contenido FROM usuarios WHERE id = $idSeguido ";

    $result = mysqli_query($conn, $sql);

    while ($datos = mysqli_fetch_array($result)) {
        $bytesImagen = $datos["foto_contenido"];
    }

    $sql2 = " SELECT nombre, apellido, nombreusuario FROM usuarios WHERE id = $idSeguido ";

    if ($re = mysqli_query($conn, $sql2)) {

        while ($row = mysqli_fetch_array($re)) {
            if (isset($row[0])) {
                $nombreSeguido  = $row["nombre"];
                $apellidoSeguido = $row["apellido"];
                $usuarioSeguido = $row["nombreusuario"];
            }
        }
    }
        else {  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

    ?>

    
   



<header class="header">
    <div class="container logo-nav-container">
      <img class="logoW" src="static/img/logo2.jpg" />
      <a href="inicio.php" class="logo"> The Wall</a>
      </div>
      <nav class="navegacion">
        <ul >
          <li>
          <form  action="#" method="POST"  onsubmit="return validarBuscar();">
            
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




    <div class="contenedorPerfilUsuario">
        <div class="fotoPerfil">
        <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar" alt="">
        <h3 class="nombre"><?php echo "$nombreSeguido "; echo $apellidoSeguido; ?></h3>
        <h3 class="nombre"><?php echo $usuarioSeguido ?></h3>
        
        
        
        
  
        <?php 
        $sql3= "SELECT COUNT(s.id) FROM siguiendo s WHERE $idLogueado=s.usuarios_id AND $idSeguido=s.usuarioseguido_id";
        $rs=mysqli_query($conn,$sql3);
        while($row = mysqli_fetch_row($rs)){
            if($row[0]==1){ ?>
                <form  action="validarDejarDeSeguir.php" method="POST" >
                  <input type="hidden"   name="usuarioSeguido" value="<?php echo $usuarioSeguido?>">
                  <input type="hidden"    name="US_id" value="<?php echo $idSeguido?>"> 
                  
                  <button type= "submit" class="dejarDeSeguir"  >Dejar de Seguir</button>
                </form>        
            <?php }
            elseif($row[0]==0){ ?>
                <?php if ($idSeguido!=$idLogueado){ ?> 
                <form  action="validarSeguir.php" method="POST" >
                <input type="hidden"   name="usuarioSeguido" value="<?php echo $usuarioSeguido?>">
                <input type="hidden"    name="US_id" value="<?php echo $idSeguido?>"> 
                <button type= "submit" class="seguir"  >Seguir</button>
                </form>
            <?php } }
        }?>
        
    
        
        

        


        </div>
    </div>

    <div class="mensajes">
        <ul class="men-box">
          
            <h3 class="nombre">Mensajes</h3>

            
            <?php
              $rs=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idSeguido' ORDER BY fechayhora DESC" );
              $mensajes_por_pagina=10;
              $cantidad=$rs->num_rows;
              $start= ($_GET['pagina']-1)*$mensajes_por_pagina;    
              $paginas=ceil($cantidad/$mensajes_por_pagina);

              $re=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idSeguido' ORDER BY fechayhora DESC LIMIT $start, $mensajes_por_pagina" );
              
              while ($row = mysqli_fetch_array($re)  ) {
                    
                ?>    
                <?php echo "<li>$row[0] </li> " ;
                if(isset($row[1])){
                    $bytesImagen = $row["imagen_contenido"];?>
                    <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " width="500"><?php
                }
                ?>
                <?php $idMensaje=$row[2];
                $sqlMG="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id";
                $rsMG=mysqli_query($conn, $sqlMG);
                if ($rowMG=mysqli_fetch_array($rsMG)){
                    $cantMG=$rowMG[0];
                }?>
                <?php
                
                $idMensaje=$row[2];
                $sql3="SELECT COUNT(mg.id) FROM me_gusta mg WHERE $idMensaje=mg.mensaje_id AND $idLogueado=mg.usuarios_id ";
                $rs2=mysqli_query($conn, $sql3);
               if ($row=mysqli_fetch_row($rs2)){
                    if($row[0]==0){?>
                        <form action="ponerMeGusta.php" method="post" class="form-mensaje">
                        <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                        <input type="submit" value="Me gusta (<?php echo $cantMG ?>)" class="meGusta">
                        </form>>
                    <?php }
                    elseif ($row[0]==1){?>
                        <form action="quitarMeGusta.php" method="post" class="form-mensaje">
                        <input type="hidden"   name="idMensaje" value="<?php echo $idMensaje?>">
                        <input type="submit" value="Ya no me gusta(<?php echo $cantMG ?>)" class="yaNoMeGusta">
                        </form>
                <?php }  
                } ?>
             
                
            <?php } ?>
            <?php
            

            
            ?>
                
            </li>


        </ul>
        <ul class="nav nav-pills justify-content-center">
    <li class="page-item <?php echo $_GET['pagina']<= 1 ? 'disabled' : '' ?>  ">
      <a class="page-link" href="perfilUsuario.php?idUsuario=<?php echo $idSeguido ?>&pagina=<?php echo $_GET['pagina']-1 ?>" > Anterior</a>
      </li>
      <?php for ($i=0; $i<$paginas ;$i++ ) { ?>
        <li class="page-item ">
          <a class="page-link <?php echo $_GET['pagina']==$i+1 ? 'active' : '' ?> " href="perfilUsuario.php?idUsuario=<?php echo $idSeguido ?>&pagina=<?php echo $i+1 ?>" > <?php echo $i+1 ?></a>
        </li>
      <?php } ?>
      <li class="page-item <?php echo $_GET['pagina']>= $paginas ? 'disabled' : '' ?>  ">
        <a class="page-link" href="perfilUsuario.php?idUsuario=<?php echo $idSeguido ?>&pagina=<?php echo $_GET['pagina']+1 ?>">Siguiente</a>
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