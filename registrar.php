<?php
     require 'BD.php';
    //if (!empty($_POST['apellidos']) && !empty($_POST['nombre']) && !empty($_POST['clave')]){
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $clave =  $_POST['clave'];
        $clave2 =  $_POST['clave2'];
        $email =  $_POST['correo'];
        $nombreUsuario =  $_POST['usuario'];
        $sql = "INSERT INTO usuarios (apellido, nombre, contrasenia, email, nombreUsuario) VALUES ('$apellido', '$nombre','$clave','$email', '$nombreUsuario')"; 
        //$result  = mysqli_query($conn, $sql);
        //$result->bindParam(':apellidos', $_POST['apellidos']);
        //$result->bindParam(':nombre', $_POST['nombre']);
        if (mysqli_query($conn, $sql)) {
            echo "Nuevo registro.";
        }
        else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    //}

?>