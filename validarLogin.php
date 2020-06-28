<?php
include 'claseVerificar.php';
require 'BD.php';

if ((!empty($_POST['usuario']))  && (!empty($_POST['clave']))) {
    $clave =  $_POST['clave'];
    $nombreUsuario =  $_POST['usuario'];


    if (Verificar::usuario_duplicado($nombreUsuario, $error_usuarioDuplicado)) {
        echo "El usuario no existe";
    } else {
        if (Verificar::obtener_claveUsuario($nombreUsuario, $clave, $error_coincideClaveUsuario)) {
            session_start();
            $rs = mysqli_query($conn, "SELECT nombre FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
            if ($row = mysqli_fetch_row($rs)) {
                $nombre = trim($row[0]);
            }
            $rs = mysqli_query($conn, "SELECT apellido FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
            if ($row = mysqli_fetch_row($rs)) {
                $apellido = trim($row[0]);
            }

            $_SESSION['usuario'] = $nombreUsuario;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            //obtengo id de usuario
            $rs = mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
            if ($row = mysqli_fetch_row($rs)) {
                $id = trim($row[0]);
            }
            $_SESSION['id'] = $id;
            header("Location:index.php");
        } else {
            echo "$error_coincideClaveUsuario";

        }
    }
} else {
    echo "sale por el emty";
}
