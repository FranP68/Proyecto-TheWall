<!doctype html>


<?php


    include 'claseVerificar.php';
    require 'BD.php';

    session_start();
    $usuario = $_SESSION['usuario'];
    $emailActual = $_SESSION['email'];
    $alert ="";
    if (isset($_POST['submit'])){
    if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  )  &&   (  !empty($_POST['correo']) ) ) 
    { 
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $email =  $_POST['correo'];
        

       
        // verificar nombre
        $nombreOk=Verificar::validar_nombre($nombre,$error_nombre);

        // ---------------------

        // verificar apellido

        $apellidoOk = Verificar::validar_apellido($apellido,$error_apellido); 

        // ---------------------

        // verificar email

        $emailOk = Verificar::validar_email($email, $error_email);

        // ---------------------

        if($email==$emailActual){
            $emailDuplicadoOk=true;
        }
        else{
            $emailDuplicadoOk = Verificar::email_duplicado($email,$error_emailDuplicado);
        }
        

        if( $nombreOk && $emailOk && $apellidoOk && $emailDuplicadoOk){
            //actualizo usuario en la base de datos
            
            if(empty($_FILES['img']['name']) ){
                $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email'  WHERE nombreusuario='$usuario' ";
            }
            elseif(!empty($_FILES['img']['name']) ){
                
                $imagenTmp = $_FILES['img']['tmp_name'];
                $imagenType = $_FILES['img']['type'];
                $bytesImagen = addslashes(file_get_contents($imagenTmp));
                $tipo=substr($imagenType, 6);
                if (Verificar::validar_foto($tipo,$error_foto)){             
                    $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email', foto_contenido='$bytesImagen', foto_tipo='$tipo'  WHERE nombreusuario='$usuario' ";
                }
                else{
                    $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email'  WHERE nombreusuario='$usuario' ";
                    // echo $error_foto;
                }
            }
            
            if (mysqli_query($conn, $sql1)) {
                $alert = "Datos actualizados";
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] =$apellido; 
                $_SESSION['correo'] = $email; 
                
                $bool= true;
                header("Location:miPerfil.php");
                
            }
            else{
                //echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }
        }else{
            if (!$emailDuplicadoOk)
                $alert = $alert . "$error_emailDuplicado";
            if (!$emailOk)
                 $alert = $alert . "$error_email";
                
            if (!$nombreOk)
                $alert = $alert . "$error_nombre";
                
            if (!$apellidoOk)
                $alert = $alert . "$error_apellido";
        }    
        }



    
    else{
        if(  empty($_POST['apellidos']) ){
            $alert = $alert . "El apellido no está definido"."<br>";
        }
        if(  empty($_POST['nombre']) ){
            $alert = $alert . "El nombre no está definido"."<br>";
        }
        if(  empty($_POST['correo']) ){
            $alert= $alert . "El correo no está definido"."<br>";
        }
       
    }
    //header("Location:editarPerfil.php");
        $bool = false;
    }


?>




<?php
  
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="static/css/pancho.css">
  <link rel="stylesheet" type="text/css" href="static/css/estilos.css">
  <title>The Wall</title>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- <script src="static/js/validarEdit.js"></script> -->
   <script src="static/js/validar.js"></script>
</head>




  
  <body>
    
  <?php
      require "BD.php";
      
      $usuario = $_SESSION['usuario'];
      $nombre = $_SESSION['nombre'];
      $apellido = $_SESSION['apellido'];
      $email = $_SESSION['email'];
  ?>
    
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


      <main class="main">
    <div class="modal-dialog text-center">
        <div class="col-sm-12 main-section">
          <div class="modal-content">
            <div class="col-12 user-img">
              <?php $sql = " SELECT foto_contenido FROM usuarios WHERE nombreusuario = '$usuario' ";
  
              $result = mysqli_query($conn, $sql);

              while ( $datos = mysqli_fetch_array($result) ){ 
                $bytesImagen = $datos["foto_contenido"];
              }
              ?>
  
  <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
            </div>
    <form  class="col-12"  method="POST" class="form-register" enctype="multipart/form-data" onsubmit="return validarEditarPerfil(img);">
        <div class="form-group" id="user-group"></div>
        <h2 class="form__titulo">Editar Perfil</h2>
        <div class="contenedor-inputs">
            <div class="form-group" id="user-group">
            <input type="text" id="nombre" name="nombre" value="<?PHP echo $_SESSION['nombre'] ?>" class="form-control" >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="apellidos" name="apellidos" value="<?PHP echo $apellido ?>" class="form-control"  >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="correo" name="correo" value="<?PHP echo $email ?>" class="form-control">
            <div class="form-group" id="user-group">
                <span class="nuestroinput">
                    <input type="file" name="img" id="foto"   placeholder="Seleccione foto de perfil" ><!-- class="nuestroinput" id="nuestroinput"-->
                </span>
            
        </div>
            
        </div>
        <button type="submit" name="submit" onclick="preguntar2()" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>  Guardar Cambios</button>
        <script type="text/javascript">
                    function preguntar2(){
                      if ( confirm( "¿Esta seguro que desea actualizar sus datos?" ) ){
                        // window.location.href = "http://localhost/ProyectoPHP/Proyecto-TheWall/miPerfil.php";
                      }
                      
                    }
        </script>    
        <?php 
             echo " <p> $alert </p>" ;
        ?> 
        

      </form>
      
</main>
    


<!-- Footer -->
<footer class="page-footer font-small blue">

   
    <div class="footer">
      <a> Francisco Pavon - Santiago Goggi</a>
    </div>
  
  </footer>
  <!-- Footer -->
</body>


</html>

