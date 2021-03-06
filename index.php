<?php
include 'claseVerificar.php';
require 'BD.php';
$alert = '';
if (isset($_POST['submit'])) {
  if ((!empty($_POST['usuario']))  && (!empty($_POST['clave']))) {
    $clave =  $_POST['clave'];
    $nombreUsuario =  $_POST['usuario'];
    try {
      Verificar::validar_login($nombreUsuario, $clave);

      header("Location:inicio.php");
    } catch (Verificar $e) {

      $alert = $e->getMessage();
    }
  } else {

    $alert= "Todos los campos son requeridos";
  }
}
?>



<!DOCTYPE html>
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
  <link rel="stylesheet" type="text/css" href="static/css/estilos.css">

  <script src="static/js/validar.js"></script>

</head>



<body>

  <header class="header">
    <div class="container logo-nav-container">
      <img class="logoW" src="static/img/logo2.jpg" />
      <a href="#" class="logo" class="tituloWeb"> The Wall</a>
      <nav class="navegacion">
        <ul>
          <!-- <li><a href="#">Inicio </a></li> 
      <li><a href="miPerfil.php">Perfil </a></li> 
      <li><a href="#"> Cerrar Sesion </a></li>  -->
        </ul>
      </nav>
    </div>
  </header>

  <main>

    <div class="modal-dialog text-center">
      <div class="col-sm-8 main-section">
        <div class="modal-content">
          <div class="col-18 user-img">
            <img src="static/img/avatar.png" />
          </div>
          <form class="col-12" action="index.php" method="POST" onsubmit="return validarIndex();">
            <div class="form-group" id="user-group">
              <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de Usuario">
            </div>
            <div class="form-group" id="contraseña-group">
              <input type="password" id="clave" name="clave" class="form-control" placeholder="Contraseña">

            </div>
            <!-- Informa el error de login -->
            <p><?php echo $alert  ?> </p>
            <input type="submit" name="submit" value="Iniciar sesión"  class="btn btn-primary">
          </form>
          <div class="col-12">
            <p>¿No tienes una cuenta? <a class="link" href="registrarse.php">Registrate </a> </p>
          </div>




        </div>
      </div>

    </div>



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