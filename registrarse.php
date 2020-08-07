 <?php
  require 'BD.php';
?>
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
        <link rel="stylesheet" type="text/css"  href="static/css/estilos.css">
        <script src="static/js/validar.js"></script>
      
      </head>
      

<body>
    
    <header class="header">
        <div class="container logo-nav-container">
          <img class="logoW" src="static/img/logo2.jpg" />
          <a href="index.php" class="logo"> The Wall</a>
          <nav class="navegacion">
            <ul>
         
         </ul>
          </nav>
        </div>
      </header>

      <main class="main">
    <div class="modal-dialog text-center">
        <div class="col-sm-12 main-section">
          <div class="modal-content">
            <div class="col-12 user-img">
              <img src="static/img/avatar.png" />
            </div>
    <form  class="col-12" action="registrar.php" method="POST" class="form-register" enctype="multipart/form-data" action="" onsubmit="return validar(img);">
        <div class="form-group" id="user-group"></div>
        <h2 class="form__titulo">CREA UNA CUENTA</h2>
        <div class="contenedor-inputs">
            <div class="form-group" id="user-group">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" class="form-control" >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" class="form-control"  >
        </div>
        <div class="form-group" id="user-group">
            <input type="text" id="correo" name="correo" placeholder="Correo" class="form-control">
        </div>
            <div class="form-group" id="user-group">
            <input type="text" id="usuario" name="usuario" placeholder="Usuario" class="form-control">
        </div>
            <div class="form-group" id="user-group">
            <input type="password" id="clave" name="clave" placeholder="Contraseña" class="form-control">
        </div>
            <div class="form-group" id="user-group">
            <input type="password" id="clave2" name="clave2" placeholder="Repetir Contraseña" class="form-control">
        </div>
            <div class="form-group" id="user-group">
                <span class="nuestroinput">
                    <input type="file" name="img" id="foto"  value="Seleccione foto de perfil" >

                </span>
            
                
        </div>
            
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>  Registrate</button>
    </form>
    <div class="col-12">
      <p>¿Ya tienes una cuenta? <a class="link" href="index.php">Iniciar Sesion </a>  </p>
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

</php>