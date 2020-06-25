<?php
    require 'BD.php';
    if (!empty($_POST['apellidos']) && !empty($_POST['nombre']) && !empty($_POST['clave')]){
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $clave =  $_POST['clave'];
        $clave2 =  $_POST['clave2'];
        $email =  $_POST['correo'];
        $nombreUsuario =  $_POST['usuario'];
        $imagen = $_FILES['img']['name'];
        $imagenType = $_FILES['img']['type'];
        $tipo=substr($imagenType, 6);
        $sql = "INSERT INTO usuarios(apellido, nombre, contrasenia, email, nombreUsuario, foto_contenido, foto_tipo) VALUES ('$apellido', '$nombre', '$clave', '$email', '$nombreUsuario', '$imagen', '$tipo') "; 
        if (mysqli_query($conn, $sql)) {
            echo "Nuevo registro.";
        }
        else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

?>