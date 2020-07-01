<!doctype html>
<html lang="es">
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
            <a href="#" class="logo"> The Wall</a>
            <nav class="navegacion">
                <ul>
                    <li>
                    <form  action="buscar.php" method="POST" >
            
            <input type="text" name="busqueda" id="buscador" placeholder="Buscar usuario" class="form-control" required>
            </li>
            <button type="submit" class="btn btn-info mb-1" id="botonBuscador"><i class="fa fa-search"></i></button>
        </form>
                    <li><a href="inicio.php">Inicio </a></li>
                    <li><a href="miPerfil.php">Perfil </a></li>
                    <li><a href="editarPerfil.php">Editar perfil</a></li>
                    <li><a href="editarContraseña.php">Editar contraseña </a></li>
                    <li><a href="index.php"> Cerrar Sesion </a></li>
                </ul>
            </nav>
        </div>

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
              $rs=mysqli_query ($conn, "SELECT texto,imagen_contenido,id FROM mensaje WHERE usuarios_id='$idSeguido' ORDER BY fechayhora DESC LIMIT 0,10" );
            
              while ($row = mysqli_fetch_array($rs)  ) {
                    
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