<!doctype html>

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

    <?php
    require "BD.php";
    session_start();
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idUsuario  = $_SESSION['id'];
    ?>
    <div class="contenedor">
        <div class="fotoPerfil">
            <?php $sql = " SELECT foto_contenido FROM usuarios WHERE nombreusuario = '$usuario' ";

            $result = mysqli_query($conn, $sql);

            while ($datos = mysqli_fetch_array($result)) {
                $bytesImagen = $datos["foto_contenido"];
            }
            ?>

            <img src="data:image/jpeg; base64, <?php echo base64_encode($bytesImagen) ?> " class="avatar2" alt="">
            <h3 class="nombre"><?php echo "$nombre " ; echo $apellido;?></h3>
            <h3 class="nombre"><?php echo $usuario?></h3>
        </div>
        <ul class="seguidores">
            <h3 class="nombre">Seguidores:</h3>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioJuanPerez.html">Juan Perez</a> <a class="usuarioLink" type="button" href="perfilUsuarioJuanPerez.html"> (juanp1)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioCristiano.html">Cristiano Ronaldo</a> <a class="usuarioLink" type="button" href="perfilUsuarioCristiano.html"> (CR7)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>
            <li> <a class="usuarioLink" type="button" href="perfilUsuarioJuanRoman.html">Juan Roman Riquelme</a> <a class="usuarioLink" type="button" href="perfilUsuarioJuanRoman.html"> (JRR10)</a></h3>
                <button class="dejarDeSeguir">Dejar de Seguir</button>
            </li>

        </ul>

        <div class="editar-perfil">

            <a class="botonEditar" type="button" href="editarPerfil.html"> Editar perfil</a>


        </div>
    </div>

    <div class="mensajes">
        <ul class="men-box">
          
            <h3 class="nombre">Mis mensajes</h3>

            <?php $i=0;
              $rs=mysqli_query($conn, "SELECT texto FROM mensaje WHERE usuarios_id='$idUsuario' ");
              
              while ($row = mysqli_fetch_row($rs)  ) {
                    
                ?>    
                <?php echo "<li>$row[0] </li> " ?>
                <button class="meGusta">Me gusta</button>
                <button class="eliminar">Eliminar</button>
                
            <?php } ?>
           
            
            
            
            <!-- <button class="meGusta">Me gusta</button>
            <button class="eliminar">Eliminar</button> -->
            <!-- <li>Otro mensaje

            </li><button class="meGusta">Me gusta</button>
            <button class="eliminar">Eliminar</button>
            <li> -->

                <form action="nuevoMensaje.php" method="post" class="form-mensaje">
                    <div>
                        <textarea name="nuevoMensaje" placeholder="Escriba un nuevo mensaje" maxlength="140" minlength="1" style="width: 300px;height: 120px;"></textarea>
                    </div>
                    <input type="file" id="foto" class="botonImagen" onchange="validarImagen(this);" value="Seleccionar imagen">
                    <input type="submit" class="botonMensaje" value="Enviar mensaje">

                </form>
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