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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="static/css/pancho.css">
  <link rel="stylesheet" type="text/css" href="static/css/estilos.css">
  <title>Hello, world!</title>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <script src="static/js/validarEdit.js"></script>
</head>




  
  <body>
    
  <?php
      require "BD.php";
      session_start();
      $usuario = $_SESSION['usuario'];
      $nombre = $_SESSION['nombre'];
      $apellido = $_SESSION['apellido'];
      $email = $_SESSION['email'];
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
    <form  class="col-12" action="VeditarPerfil.php"  method="POST" class="form-register" enctype="multipart/form-data" onsubmit="return validarEditarPerfil();">
        <div class="form-group" id="user-group"></div>
        <h2 class="form__titulo">Editar Perfil</h2>
        <div class="contenedor-inputs">
            <div class="form-group" id="user-group">
            <input type="text" id="nombre" name="nombre" value="<?PHP echo $nombre ?>" class="form-control" >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="apellidos" name="apellidos" value="<?PHP echo $apellido ?>" class="form-control"  >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="correo" name="correo" value="<?PHP echo $email ?>" class="form-control">
            <div class="form-group" id="user-group">
                <span class="nuestroinput">
                    <input type="file" name="img"  onchange="validarImagen(this);" placeholder="Seleccione foto de perfil" ><!-- class="nuestroinput" id="nuestroinput"-->
                </span>
            
        </div>
            
        </div>
        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>  Guardar Cambios</button>
    
                                                                                                                                                                                       
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