<?php
require 'BD.php';
session_start();
if  (   (!empty($_POST['nuevoMensaje']))     )  {
    
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $idUsuario = $_SESSION['id'];
    $texto = $_POST['nuevoMensaje'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $hoy = date('Y-m-d H:i:s');
    
    if (!empty($_FILES['img']['name'])) {
        $imagenTmp = $_FILES['img']['tmp_name'];
        $imagenType = $_FILES['img']['type'];
        $bytesImagen = addslashes(file_get_contents($imagenTmp));
        $tipo = substr($imagenType, 6);
        $sql1 = "INSERT INTO mensaje(texto, imagen_contenido, imagen_tipo, usuarios_id, fechayhora) VALUES ('$texto', '$bytesImagen' , '$tipo' , '$idUsuario' , '$hoy') ";    
    }
    else{
        $sql1 = "INSERT INTO mensaje(texto, usuarios_id, fechayhora) VALUES ('$texto', '$idUsuario' , '$hoy') ";
    }
    
    if (mysqli_query($conn, $sql1)) {
        echo "Nuevo mensaje.";
        header("Location:index.php");
    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
}
