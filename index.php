<!doctype html>

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

  <script src="static/js/validar.js"></script>
</head>


<body>

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

        <script>
          const usuariosRegistrados = [
            { nombre: 'Cristiano ronaldo' },
            { nombre: 'Juan Roman Riquelme' },
            { nombre: 'Leandro Atilio Romagnoli' },
            { nombre: 'Lionel Messi' }, //esto se sacaria de la base de datos
          ]


          const buscador = document.querySelector('#buscador');
          const botonBuscador = document.querySelector('#botonBuscador');
          const resultado = document.querySelector('#resultado')

          const filtrar = () => {
            //console.log(buscador.value);
            resultado.innerHTML = '';

            const texto = buscador.value.toLowerCase();

            for (let usuarioRegistrado of usuariosRegistrados) {
              let nombre = usuarioRegistrado.nombre.toLowerCase();
              if (nombre.indexOf(texto) !== -1) {
                resultado.innerHTML += ` <a href="miPerfil.html" class="logo"> ${usuarioRegistrado.nombre}</a>`
              }
            }
            if (resultado.innerHTML === '') {
              resultado.innerHTML += `<li>Usuario no encontrado...</li>`
            }
          }
          botonBuscador.addEventListener('click', filtrar);
                    //buscador.addEventListener('keyup', filtrar)



        </script>
      </nav>
    </div>

  </header>

  <body>
    <?php
      require "BD.php";
      session_start();
      $usuario = $_SESSION['usuario'];
      $nombre = $_SESSION['nombre'];
      $apellido = $_SESSION['apellido'];
    ?>
    
    <div class="cuadroPerfil">
      <div class="fotoPerfil2">
          

      <?php $sql = " SELECT foto_contenido FROM usuarios WHERE nombreusuario = '$usuario' ";
  
        $result = mysqli_query($conn, $sql);
    
      while ( $datos = mysqli_fetch_array($result) ){ 
        $bytesImagen = $datos["foto_contenido"];
        //$tipo = $datos["foto_tipo"];
        
        // echo "<img src= 'data:image/jpeg; base64, " . base64_encode($bytesImagen) ."' >";
      }
      ?>
        
       



        <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
        <h3 class="nombre2"><?php echo "$nombre " ; echo $apellido;?> </h3>
        <h3 class="nombre2"><?php echo $usuario?></h3>
      </div>
      <div class="nuevoMensaje">
        <form action="nuevoMensaje.php" method="post" class="form-mensaje" enctype="multipart/form-data" onsubmit="return validarMensaje();" >
          <div>
            <textarea name="nuevoMensaje" id="mensaje" placeholder="Escriba un nuevo mensaje" maxlength="140" minlength="1"
              style="width: 230px;height: 120px;" ></textarea>
          </div>
          <input type="file" name="img" class="botonImagen" value="Seleccionar imagen" onchange="validarImagen(this);">
          <input type="submit" class="botonMensaje" value="Enviar mensaje">

        </form>
      </div>
    </div>

    <div class="ultimosMensajes">
      <ul class="men-box2">
        <h3 class="men-box2-title">Ultimos mensajes</h3>
        <div class="unMensaje">
          <img src="static/img/CR7.jpg" class="avatar2" alt="">
          <a class="usuarioLink" type="button" href="perfilUsuarioCristiano.html">Cristiano Ronaldo</a> <a
            class="usuarioLink" type="button" href="perfilUsuarioCristiano.html"> (CR7)</a></h3>
          <button class="dejarDeSeguir">Dejar de Seguir</button>
          <li>
            <div>
              Soy el mejor
            </div>

          </li><button class="yaNoMeGusta"> Ya no me gusta</button>
        </div>
        <div class="unMensaje">
          <img src="static/img/CR7.jpg" class="avatar2" alt="">
          <a class="usuarioLink" type="button" href="perfilUsuarioCristiano.html">Cristiano Ronaldo</a> <a
            class="usuarioLink" type="button" href="perfilUsuarioCristiano.html"> (CR7)</a></h3>
          <button class="dejarDeSeguir">Dejar de Seguir</button>
          <li>
            <div>
              Lio te amo
            </div>
            <img src="static/img/messi.jpg" class="fotoMensaje" alt="">
          </li><button class="meGusta">Me gusta</button>
        </div>
        <div class="unMensaje">
          <img src="static/img/avatar.png" class="avatar2" alt="">
          <a class="usuarioLink" type="button" href="miPerfil.html">MiNombre MiApellido</a> <a class="usuarioLink"
            type="button" href="miPerfil.html"> (MiNombreDeUsuario)</a></h3>
          <li>
            <div>
              Un mensaje
            </div>

          </li><button class="meGusta">Me gusta</button>
        </div>
        <div class="unMensaje">
          <img src="static/img/avatar.png" class="avatar2" alt="">
          <a class="usuarioLink" type="button" href="miPerfil.html">MiNombre MiApellido</a> <a class="usuarioLink"
            type="button" href="miPerfil.html"> (MiNombreDeUsuario)</a></h3>
          <li>
            <div>
              Otro mensaje
            </div>

          </li><button class="meGusta">Me gusta</button>
        </div>
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