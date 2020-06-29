<!doctype html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
          const usuariosRegistrados = [{
              nombre: 'Cristiano ronaldo'
            },
            {
              nombre: 'Juan Roman Riquelme'
            },
            {
              nombre: 'Leandro Atilio Romagnoli'
            },
            {
              nombre: 'Lionel Messi'
            }, //esto se sacaria de la base de datos
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
                resultado.innerHTML += ` <a href="miPerfil.php" class="logo"> ${usuarioRegistrado.nombre}</a>`
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
        

          <?php $sql2 = " SELECT m.texto, m.imagen_contenido, u.nombre, u.apellido, u.nombreusuario, u.foto_contenido, s.usuarioseguido_id FROM mensaje m INNER JOIN siguiendo s ON (s.usuarioseguido_id = m.usuarios_id) INNER JOIN usuarios u ON (u.id = m.usuarios_id) WHERE ($idLogueado = s.usuarios_id) ORDER BY m.fechayhora DESC "; ?>
          <?php
          if ($re = mysqli_query($conn, $sql2)) {

            while ($row = mysqli_fetch_array($re)) {
              if (isset($row[0])) {
                $bytesImagen = $row["foto_contenido"]; ?>
                <form action="validarSeguir.php" method="POST" >
                <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
                <?php
                $nombreU = $row["nombre"];
                $apellidoU = $row["apellido"];
                $usuarioSeguido = $row["nombreusuario"];
                $usuarioSeguido_id=$row[6];
                ?>

                <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $usuarioSeguido_id ?>"><?php echo "$nombreU "; echo $apellidoU; ?></a>
                <a class="usuarioLink" type="button" href="perfilUsuario.php?idUsuario=<?php echo $usuarioSeguido_id ?>"><?php echo "($usuarioSeguido)" ?></a></h3>
                
                
                  <input type="hidden"   name="usuarioSeguido" value="<?php echo $usuarioSeguido?>">
                  <input type="hidden"    name="US_id" value="<?php echo $usuarioSeguido_id?>">
                  <button type= "submit" class="dejarDeSeguir"  >Dejar de Seguir</button>
                </form>
                <div class="unMensaje">        
                <li>
                  <div>

                    <?php


                    ?>
                    <?php echo "$row[0] <br><br>";
                    if (isset($row[1])) {
                      $bytesImagen = $row["imagen_contenido"]; ?>
                      <img src='data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> ' style="width: 300px;height: 190px;"><?php
                    }?>
                   
                </li> <button class="meGusta">Me gusta</button>
              <?php } else {
                echo "El mensaje esta en blanco";
              }
            }
          } else {
            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
          } ?>
                  </div>
        </div>
    </div>
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