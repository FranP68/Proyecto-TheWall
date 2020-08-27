<?php 
    require "BD.php";
    session_start();
    $idSeguido = $_POST ["US_id"];
    $idLogueado = $_SESSION["id"];
    $usuarioSeguido= $_POST ["usuarioSeguido"];
    $sql1 = " INSERT INTO siguiendo(usuarios_id, usuarioseguido_id) VALUES ($idLogueado,$idSeguido)";
    if ($r = mysqli_query($conn, $sql1) ){
        echo "Ha seguido a @$usuarioSeguido ";
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    else{
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
    
    ?>